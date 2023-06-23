<?php
define('DB_SERVER','localhost');
define('DB_USER','isquavhc_demo1');
define('DB_PASS' ,'uy8MQNlt?7Bx');
define('DB_NAME', 'isquavhc_voice_of_day');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


?>