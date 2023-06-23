<?php 
session_start();
include('include/config.php');
if($_SESSION['userid']!=123 && $_SESSION['userlogintime']=="")
{
	header("Location: index.php"); exit;
}
function displayPaginationBelow($per_page,$page){
	include('include/config.php');
$page_url="?";
$wh="";
unset($search_cars);
unset($searchParam);
$searchQuery="";

if($_REQUEST['search']!='')
	{
		$wh=" (user_name LIKE'%".$_REQUEST['search']."%' OR mycars LIKE'%".$_REQUEST['search']."%') AND ";
		$searchParam[]="search=".$_REQUEST['search'];
	}	
	if($_REQUEST['year']!='' || $_REQUEST['make']!='' || $_REQUEST['model']!='' || $_REQUEST['submodel']!='')
	{
		if($_REQUEST['year']!='')
		{
			$search_cars[]= $_REQUEST['year'];
			$searchParam[]="year=".$_REQUEST['year'];
		}
		if($_REQUEST['make']!='')	
		{
			$search_cars[]= $_REQUEST['make'];
			$searchParam[]="make=".$_REQUEST['make'];
		}
		if($_REQUEST['model']!='')	
		{
			$search_cars[]= $_REQUEST['model'];
			$searchParam[]="model=".$_REQUEST['model'];
		}
		if($_REQUEST['submodel']!='')	
		{
			$search_cars[]= $_REQUEST['submodel'];
		}
		$searchParam[]="submodel=".$_REQUEST['submodel'];		
		$scar = implode(",",$search_cars);
		$wh=$wh." mycars LIKE'%".$scar."%' AND ";
	}
	
	if(count($searchParam) > 0)
	{		
		$searchQuery = implode("&",$searchParam);
	}

		$query = "SELECT COUNT(*) as totalCount FROM mygarage_data where ".$wh." user_id !=''";
		$page_q=mysqli_query($con,$query); 
		$rec=mysqli_fetch_all($page_q, MYSQLI_ASSOC);
		$total = $rec[0]['totalCount'];
		$adjacents = "2";
		
		$page = ($page == 0 ? 1 : $page);
		$start = ($page - 1) * $per_page;
		
		$prev = $page - 1;
		$next = $page + 1;
		$setLastpage = ceil($total/$per_page);
		$lpm1 = $setLastpage - 1;
		
		$setPaginate = "";
		if($setLastpage > 1)
		{
		$setPaginate .= "<ul class='setPaginate'>";
		$setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
		if ($setLastpage < 7 + ($adjacents * 2))
		{
		for ($counter = 1; $counter <= $setLastpage; $counter++)
		{
		if ($counter == $page)
		$setPaginate.= "<li><a class='current_page'>$counter</a></li>";
		else
		$setPaginate.= "<li><a href='{$page_url}page=$counter$searchQuery'>$counter</a></li>";
		}
		}
		elseif($setLastpage > 5 + ($adjacents * 2))
		{
		if($page < 1 + ($adjacents * 2))
		{
		for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
		{
		if ($counter == $page)
		$setPaginate.= "<li><a class='current_page'>$counter</a></li>";
		else
		$setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
		}
		$setPaginate.= "<li class='dot'>...</li>";
		$setPaginate.= "<li><a href='{$page_url}page=$lpm1$searchQuery'>$lpm1</a></li>";
		$setPaginate.= "<li><a href='{$page_url}page=$setLastpage$searchQuery'>$setLastpage</a></li>";
		}
		elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		{
		$setPaginate.= "<li><a href='{$page_url}page=1$searchQuery'>1</a></li>";
		$setPaginate.= "<li><a href='{$page_url}page=2$searchQuery'>2</a></li>";
		$setPaginate.= "<li class='dot'>...</li>";
		for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
		{
		if ($counter == $page)
		$setPaginate.= "<li><a class='current_page'>$counter</a></li>";
		else
		$setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
		}
		$setPaginate.= "<li class='dot'>..</li>";
		$setPaginate.= "<li><a href='{$page_url}page=$lpm1$searchQuery'>$lpm1</a></li>";
		$setPaginate.= "<li><a href='{$page_url}page=$setLastpage$searchQuery'>$setLastpage</a></li>";
		}
		else
		{
		$setPaginate.= "<li><a href='{$page_url}page=1$searchQuery'>1</a></li>";
		$setPaginate.= "<li><a href='{$page_url}page=2$searchQuery'>2</a></li>";
		$setPaginate.= "<li class='dot'>..</li>";
		for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)
		{
		if ($counter == $page)
		$setPaginate.= "<li><a class='current_page'>$counter</a></li>";
		else
		$setPaginate.= "<li><a href='{$page_url}page=$counter$searchQuery'>$counter</a></li>";
		}
		}
		}
		
		if ($page < $counter - 1){
		//$setPaginate.= "<li><a href='{$page_url}page=$next$searchQuery'>Next</a></li>";
		$setPaginate.= "<li><a href='{$page_url}page=$setLastpage$searchQuery'>Last</a></li>";
		}else{
		//$setPaginate.= "<li><a class='current_page'>Next</a></li>";
		$setPaginate.= "<li><a class='current_page'>Last</a></li>";
		}
		
		$setPaginate.= "</ul>\n";
		}
		return $setPaginate;
}


if($_REQUEST['export']!='')
{
	$wh='';
	if($_REQUEST['search']!='')
	{
		$wh=" (user_name LIKE'%".$_REQUEST['search']."%' OR mycars LIKE'%".$_REQUEST['search']."%') AND ";
	}
	unset($search_cars);
	if($_REQUEST['year']!='' || $_REQUEST['make']!='' || $_REQUEST['model']!='' || $_REQUEST['submodel']!='')
	{
		if($_REQUEST['year']!='')	
			$search_cars[]= $_REQUEST['year'];
		if($_REQUEST['make']!='')	
			$search_cars[]= $_REQUEST['make'];
		if($_REQUEST['model']!='')	
			$search_cars[]= $_REQUEST['model'];
		if($_REQUEST['submodel']!='')	
			$search_cars[]= $_REQUEST['submodel'];
			
		
		$scar = implode(",",$search_cars);
		$wh=$wh." mycars LIKE'%".$scar."%' AND ";
	}
	
	
	$sql = "SELECT * FROM mygarage_data where ".$wh." user_id !='' ORDER BY id DESC";
	$sql_1=mysqli_query($con,$sql); 
	$items_s=mysqli_fetch_all($sql_1, MYSQLI_ASSOC);
	if(count($items_s)> 0)
	{
		$delimiter = ","; 
		$filename = "Garage_report" . date('Y-m-d') . ".csv"; 
		$f = fopen('php://memory', 'w');
		$fields = array('Customer Name', 'Customers Email', 'Car'); 
		fputcsv($f, $fields, $delimiter); 
		for($i=0;$i<count($items_s);$i++) 
		{			 	
			$cars= explode("||",$items_s[$i]['mycars']);			
            foreach($cars as $key=>$car)
            {
                $carInfo = str_replace(","," ",$car);
				$lineData = array($items_s[$i]['user_name'],$items_s[$i]['user_email'],$carInfo); 
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
$setLimit = 3;
$pageLimit = ($page * $setLimit) - $setLimit;
$wh='';
if($_REQUEST['search']!='')
{
	$wh=" (user_name LIKE'%".$_REQUEST['search']."%' OR mycars LIKE'%".$_REQUEST['search']."%') AND ";
}
unset($search_cars);
if($_REQUEST['year']!='' || $_REQUEST['make']!='' || $_REQUEST['model']!='' || $_REQUEST['submodel']!='')
{
	if($_REQUEST['year']!='')	
		$search_cars[]= $_REQUEST['year'];
	if($_REQUEST['make']!='')	
		$search_cars[]= $_REQUEST['make'];
	if($_REQUEST['model']!='')	
		$search_cars[]= $_REQUEST['model'];
	if($_REQUEST['submodel']!='')	
		$search_cars[]= $_REQUEST['submodel'];
		
	
	$scar = implode(",",$search_cars);
	$wh=$wh." mycars LIKE'%".$scar."%' AND ";
}
$sql = "SELECT * FROM mygarage_data where ".$wh." user_id !='' ORDER BY id DESC LIMIT ".$pageLimit." , ".$setLimit;
$sql_1=mysqli_query($con,$sql); 
$items_s=mysqli_fetch_all($sql_1, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CoverKing Garage Report</title>
    <!-- plugins:css -->   
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- End Layout styles -->
       <link rel="shortcut icon" href="images/favicon.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
  </head>
  <body>
    <div class="container-scroller">
      <!--
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="index.html"></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"></a>
        </div>
        
      </nav> -->
      <!-- partial -->
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
                <div class="title_bar"><div class="titlebox"><h2>Garage Report</h2></div>
                <div class="frmbox"><form action="" method="post"><label for="search">Search </label>
                <div class="searchbox"><input type="text" name="search" id="search" value="<?php echo $_REQUEST['search'];?>" placeholder="Search by name or Car"></div>
				<div class="orseperator"> OR </div>
                <div class="row justify-content-center">
<select name="year" id="year-1" class="custom-select" onChange="getMake(this.value)"><option value="year" disabled="disabled" selected="selected">Year</option></select>
<select name="make" id="make-1" disabled="disabled" class="custom-select" onChange="getModel(this.value)"><option value="make"  disabled="disabled" selected="selected">Make</option></select>
<select name="model" id="model-1" disabled="disabled" class="custom-select" onChange="getSubmodel(this.value)"><option value="model" disabled="disabled" selected="selected">Model</option></select>
<select name="submodel" id="submodel-1" disabled="disabled" class="custom-select"><option value="submodel" disabled="disabled" selected="selected">Submodel</option> </select>
  </div>
  
  <button type="submit" class="input-group-text btn-link bg-transparent border-left-0 py-1 pr-5"><i class="fa fa-search icon-search"></i></button>
                </form>
                <?php if(count($items_s)> 0){?>                
                <div class="btnlinks">
					<?php if($_REQUEST['search']!=''){?><a href="?export=s&search=&year=<?php echo $_REQUEST['search']?><?php echo $_REQUEST['year']?>&make=<?php echo $_REQUEST['make']?>&model=<?php echo $_REQUEST['model']?>&submodel=<?php echo $_REQUEST['submodel']?>">Export filter records only</a><?php }?>
                    <a href="?export=s">Export All</a>
                </div>
                <?php }?>
                </div>
				
                </div>
                  
				  <table cellpadding="10" cellspacing="1" width="100%" style="border-collapse: unset; margin:0 auto;" bgcolor="#CCCCCC">
<tbody bgcolor="#FFFFFF">
<?php if(count($items_s)> 0){?>
<tr><th>Name</th><th>Email</th><th>Car(s)</th></tr>
	<?php 
   for($i=0;$i<count($items_s);$i++) {		
		?>
        <tr>
            <td><?php echo $items_s[$i]['user_name']?></td>
            <td><?php echo $items_s[$i]['user_email']?></td>
            <td><?php $cars= explode("||",$items_s[$i]['mycars']);
			
            foreach($cars as $key=>$car)
            {
                echo str_replace(","," ",$car)."<br>";
            }
            ?></td>
        
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

echo displayPaginationBelow($setLimit,$page);
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
	$('#year-1').append(new Option("Loading",""))
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
	$('#make-1').append(new Option("Loading",""))
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
		$('#model-1').append(new Option("Loading",""))
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
		$('#submodel-1').append(new Option("Loading",""))
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