<?php
	$server = "";
	$user="";
	$pass="";
	$conn = mysqli_connect($server, user, $pass)
	if (!$conn) {
		die("Connection Failed: " . mysqli_connect_error() . "\n");
	}
?>