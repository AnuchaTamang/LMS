<?php
$server="localhost:3307";
$username="root";
$password="";
$databasename="library_management_system";

$conn = mysqli_connect($server, $username, $password);

$abc=mysqli_select_db($conn,$databasename);

if(!$abc)
{
	die("disconnect");
}
else
{
	//die ("successfull");
}
?>