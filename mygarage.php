<?php 
header("Access-Control-Allow-Origin: *");
//include('include/config.php');
###
define("HOST","ckmysql.mysql.database.azure.com");
define("DB","coverking_garages");
define("DBUSERNAME","ckdevelop");
define("DBPASSWORD","4gdfg46435Ofsjb76fsJAF3450bn!");
###

### DB CONNECTION ###
$con = mysqli_connect(HOST,DBUSERNAME,DBPASSWORD,DB);
if($_REQUEST['userid']!="" && $_REQUEST['fetchgarage']=="")
{
	$sel="SELECT * FROM mygarage_data WHERE `user_id`='".$_REQUEST['userid']."' ORDER BY id DESC";   
	$data = mysqli_query($con,$sel);
	mysqli_affected_rows($con);
  if(mysqli_affected_rows($con)>0)
  {
	  $row = mysqli_fetch_array($data);	  
	  $upd="UPDATE `mygarage_data` SET `user_name` = '".$_REQUEST['username']."',`user_email` = '".$_REQUEST['useremail']."',`mycars` = '".$_REQUEST['garage']."' WHERE `user_id` = ".$row['user_id'];
	  mysqli_query($con,$upd); 
  }
  else
  {	
	$ord = "INSERT INTO `mygarage_data` (`user_id`,`user_name`,`user_email`, `mycars`,`last_modified`) VALUES ('".$_REQUEST['userid']."','".$_REQUEST['username']."','".$_REQUEST['useremail']."', '".$_REQUEST['garage']."','".date("Y-m-d h:s:i")."')";
	mysqli_query($con,$ord); 
  }
  
  if($_REQUEST['garage']!='')
  {
	$cars = "DELETE FROM `mygarage_cars` WHERE `user_id` = '".$_REQUEST['userid']."'";
	mysqli_query($con,$cars); 
	$arr = explode("||",$_REQUEST['garage']);
	for($i=0;$i<count($arr);$i++)
	{
		$arr2= explode(",", $arr[$i]);
		$ord = "INSERT INTO `mygarage_cars` (`user_id`,`user_name`,`user_email`, `year`,`make`,`model`,`submodel`,`type`,`adddate`) 
		VALUES ('".$_REQUEST['userid']."','".$_REQUEST['username']."','".$_REQUEST['useremail']."', '".$arr2[0]."', '".$arr2[1]."', '".$arr2[2]."', '".$arr2[3]."', '".$arr2[4]."','".date("Y-m-d h:s:i")."')";
		mysqli_query($con,$ord); 
	}
  }
}
elseif($_REQUEST['userid']!="" && $_REQUEST['fetchgarage']=="true")
{
	$sel="SELECT mycars FROM mygarage_data WHERE `user_id`='".$_REQUEST['userid']."' ORDER BY id DESC";   
  $data = mysqli_query($con,$sel);
  $row = mysqli_fetch_array($data);	  
  echo $row['mycars'];
}
?>