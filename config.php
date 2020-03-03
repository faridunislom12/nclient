<?php

$conn = mysqli_connect("localhost", "root", "") or die("Error connecting to database: ".mysqli_error());

mysqli_set_charset($conn, "utf8");
	
mysqli_select_db($conn,"nc") or die("Error connecting to database: ".mysqli_error());

	
?>
