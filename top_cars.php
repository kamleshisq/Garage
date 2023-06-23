<?php 
session_start();
include('include/config.php');
if($_SESSION['userid']!=123 && $_SESSION['userlogintime']=="")
{
	header("Location: index.php"); exit;
}
if($_REQUEST['export']!='')
{
	$wh='';	
	unset($search_cars);
	/*if($_REQUEST['year']!='' || $_REQUEST['make']!='' || $_REQUEST['model']!='' || $_REQUEST['submodel']!='')
	{
		if($_REQUEST['year']!='')	
			$search_cars[]= "year='".$_REQUEST['year']."'";
		if($_REQUEST['make']!='')	
			$search_cars[]= "make='".$_REQUEST['make']."'";
		if($_REQUEST['model']!='')	
			$search_cars[]= "model='".$_REQUEST['model']."'";
		if($_REQUEST['submodel']!='')	
			$search_cars[]= "submodel='".$_REQUEST['submodel']."'";	
		$scar = implode(" AND ",$search_cars);
		$wh=$wh.$scar." AND ";
	}*/
	
	
	$sql = "SELECT year,make,model,count(`id`) as totalcar FROM mygarage_cars where ".$wh." user_id !=''  GROUP BY model ORDER BY totalcar DESC";
	$sql_1=mysqli_query($con,$sql); 
	$items_s=mysqli_fetch_all($sql_1, MYSQLI_ASSOC);
	if(count($items_s)> 0)
	{
		$delimiter = ","; 
		$filename = "Garage_top_cars" . date('Y-m-d') . ".csv"; 
		$f = fopen('php://memory', 'w');
		$fields = array('Year', 'Make','Model','Total Car(s)'); 
		fputcsv($f, $fields, $delimiter); 
		for($i=0;$i<count($items_s);$i++) 
		{			 	
			$cars= explode("||",$items_s[$i]['mycars']);			
            foreach($cars as $key=>$car)
            {
                $carInfo = str_replace(","," ",$car);
				$lineData = array($items_s[$i]['year'],$items_s[$i]['make'],$items_s[$i]['model'],$items_s[$i]['totalcar']); 
        		fputcsv($f, $lineData, $delimiter);
            }			
		}
		fseek($f, 0); 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		fpassthru($f);
		exit;
	}
}

if(isset($_GET["page"]))
	$page = (int)$_GET["page"];
else
	$page = 1;
	$setLimit = 20;
	$pageLimit = ($page * $setLimit) - $setLimit;
	$wh='';
	unset($search_cars);
/*
if($_REQUEST['year']!='' || $_REQUEST['make']!='' || $_REQUEST['model']!='' || $_REQUEST['submodel']!='')
{
	if($_REQUEST['year']!='')	
		$search_cars[]= "year='".$_REQUEST['year']."'";
	if($_REQUEST['make']!='')	
		$search_cars[]= "make='".$_REQUEST['make']."'";
	if($_REQUEST['model']!='')	
		$search_cars[]= "model='".$_REQUEST['model']."'";
	if($_REQUEST['submodel']!='')	
		$search_cars[]= "submodel='".$_REQUEST['submodel']."'";	
	$scar = implode(" AND ",$search_cars);
	$wh=$wh.$scar." AND ";
}
*/
$sql = "SELECT year,make,model,count(`id`) as totalcar FROM mygarage_cars where ".$wh." user_id !=''  GROUP BY model ORDER BY totalcar DESC LIMIT ".$pageLimit." , ".$setLimit;
$sql_1=mysqli_query($con,$sql); 
$items_s=mysqli_fetch_all($sql_1, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CoverKing Top Vehicles </title>
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <link rel="shortcut icon" href="images/favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
			<?php require_once('include/nav.php'); ?>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Page Title Header Starts-->
            
            <!-- Page Title Header Ends-->
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                <div class="title_bar"><div class="titlebox"><h2>Top Vehicles</h2></div>
                <div class="frmbox"><form action="" method="post">
                
                
 <!--
				
                <div class="row justify-content-center">               <label for="search">Filter By </label>             
<select name="year" id="year-1" class="custom-select" onChange="getMake(this.value)"><option value="year" disabled="disabled" selected="selected">Year</option></select>
<select name="make" id="make-1" disabled="disabled" class="custom-select" onChange="getModel(this.value)"><option value="make"  disabled="disabled" selected="selected">Make</option></select>
<select name="model" id="model-1" disabled="disabled" class="custom-select" onChange="getSubmodel(this.value)"><option value="model" disabled="disabled" selected="selected">Model</option></select>
<select name="submodel" id="submodel-1" disabled="disabled" class="custom-select"><option value="submodel" disabled="disabled" selected="selected">Submodel</option> </select>
<button type="submit" class="input-group-text btn-link bg-transparent border-left-0 py-1 pr-5"><i class="fa fa-search icon-search"></i></button>
  </div>-->
                </form>
                <?php if(count($items_s)> 0){?>                
                <div class="btnlinks">
					<?php if($_REQUEST['year']!=''){?><a href="?export=s&year=<?php echo $_REQUEST['year']?>&make=<?php echo $_REQUEST['make']?>&model=<?php echo $_REQUEST['model']?>&submodel=<?php echo $_REQUEST['submodel']?>">Export filter records only</a><?php }?>
                    <a href="?export=s">Export All</a>
                </div>
                <?php }?>
                </div>
				
                </div>
                  
				  <table cellpadding="10" cellspacing="1" width="100%" style="border-collapse: unset; margin:0 auto;" bgcolor="#CCCCCC">
<tbody bgcolor="#FFFFFF">
<?php if(count($items_s)> 0){?>
<tr><th>Year</th><th>Make</th><th>Model</th><th>Total Car(s)</th></tr>
	<?php 
   for($i=0;$i<count($items_s);$i++) {		
		?>
        <tr>
            <td><?php echo $items_s[$i]['year']?></td>
            <td><?php echo $items_s[$i]['make']?></td>
             <td><?php echo $items_s[$i]['model']?></td>
              <td><?php echo $items_s[$i]['totalcar']?></td>
        
        </tr>
    
    <?php }
}
else
{
	echo "Sorry, car not found...";
}
 ?>
</tbody>
</table>
</div>

<?php
// Call the Pagination Function to load Pagination.

//echo displayPaginationBelow($setLimit,$page);
?>
                    
					
                  </div>
                </div>
              </div>
            </div>
			
            
            
            
          </div>
       
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="assets/js/shared/off-canvas.js"></script>
    <script src="assets/js/shared/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="assets/js/demo_1/dashboard.js"></script>
    <!-- End custom js for this page-->
    <script src="assets/js/shared/jquery.cookie.js" type="text/javascript"></script>
    
    <script>
	
	function getYears(){	
	//$("#make-1 option").remove();
	$("#year-1").children("option").remove();
	$('#year-1').append(new Option("Loading","Loading"))
	$('#year-1').attr("disabled");
	
    $.getJSON("https://api.coverking.com/api/Shop/years", function(result){
      $.each(result, function(j, field){
       for(var i=0; i<field.length;i=i+1)
	   {
		$('#year-1').append(new Option(field[i],field[i]))
		
	   }
      });
		$('#year-1').find(":selected").text("Select year");
	  $('#year-1').removeAttr("disabled");
    });
	}
	
	function getMake(year){	
	//$("#make-1 option").remove();
	$("#make-1").children("option").remove();
	$('#make-1').append(new Option("Loading","Loading"))
	$('#make-1').attr("disabled");
	
    $.getJSON("https://api.coverking.com/api/Shop/Makes?year="+year, function(result){
      $.each(result, function(j, field){
       for(var i=0; i<field.length;i=i+1)
	   {
		$('#make-1').append(new Option(field[i],field[i]))
		
	   }
      });
		$('#make-1').find(":selected").text("Select Make");
	  $('#make-1').removeAttr("disabled");
    });
	}
	function getModel(make){
		$("#model-1 option").remove();
		$('#model-1').append(new Option("Loading","Loading"))
		$('#model-1').attr("disabled");
	
		var year = $('#year-1').find(":selected").text();	
		$.getJSON("https://api.coverking.com/api/Shop/Models?year="+year+"&make="+make, function(result){
		  $.each(result, function(j, field){
		   for(var i=0; i<field.length;i=i+1)
		   {
			$('#model-1').append(new Option(field[i],field[i]));
			
		   }
		  });
		  $('#model-1').find(":selected").text("Select Model");
		  $('#model-1').removeAttr("disabled");
		});
	}
	function getSubmodel(model){
		$("#submodel-1 option").remove();
		$('#submodel-1').append(new Option("Loading","Loading"))
		$('#submodel-1').attr("disabled");
		
		var year = $('#year-1').find(":selected").text();	
		var make = $('#make-1').find(":selected").text();	
		
		$.getJSON("https://api.coverking.com/api/Shop/Submodel?year="+year+"&make="+make+"&model="+model, function(result){
			console.log(result);
		  $.each(result, function(j, field){
			 if(j == "Sub_Models")
			 {
			   for(var i=0; i<field.length;i=i+1)
			   {
				$('#submodel-1').append(new Option(field[i],field[i]))
			   }
			 }
		  });
		  $('#submodel-1').find(":selected").text("Select Submodel");
		   $('#submodel-1').removeAttr("disabled");
		});
	}
	
	
	$(document).ready(function(){
		getYears();
	});
    </script>
  </body>
</html>