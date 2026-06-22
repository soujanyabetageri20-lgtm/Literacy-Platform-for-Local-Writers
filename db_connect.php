<?php
$host="localhost";
$username="root";
$password="";
$database="literacy_platform";

/*create connection*/
$conn=mysqli_connect($host,$username,$password,$database);

/*check connection*/
if(!$conn)
{
	die("Database Connection failed:".mysqli_connect_error());
}

mysqli_set_charset($conn,"utf8mb4");
?>