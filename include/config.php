<?php
define('DB_SERVER','ckmysql.mysql.database.azure.com');
define('DB_USER','ckdevelop');
define('DB_PASS' ,'4gdfg46435Ofsjb76fsJAF3450bn!');
define('DB_NAME', 'coverking_garages');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


?>