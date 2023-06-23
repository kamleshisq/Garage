<?php 
session_start();

if($_SESSION['userid']!=123 && $_SESSION['userlogintime']=="")
{
	header("Location: index.php"); exit;
}else{
	session_unset();
	header("Location: index.php"); exit;
}


?>