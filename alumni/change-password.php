<?php

//To Handle Session Variables on This Page
session_start();

if(empty($_SESSION['alumni_email'])) {
  header("Location: ../index.php");
  exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

//If user Actually clicked login button 
if(isset($_POST)) {

	//Escape Special Characters in String
	$alumni_password = mysqli_real_escape_string($conn, $_POST['alumni_password']);

	//Encrypt Password
	$alumni_password = base64_encode(strrev(md5($alumni_password)));

	//sql query to check user login
	$sql = "UPDATE alumni SET alumni_password='$alumni_password' WHERE alumni_email='$_SESSION[alumni_email]'";
	if($conn->query($sql) === true) {
		header("Location: index.php");
		exit();
	} else {
		echo $conn->error;
	}

 	//Close database connection. Not compulsory but good practice.
 	$conn->close();

} else {
	//redirect them back to login page if they didn't click login button
	header("Location: settings.php");
	exit();
}