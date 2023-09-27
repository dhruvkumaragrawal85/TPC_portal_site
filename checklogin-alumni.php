<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");

//If user Actually clicked login button 
if(isset($_POST)) {

	//Escape Special Characters in String
	$alumni_email = mysqli_real_escape_string($conn, $_POST['alumni_email']);
	$alumni_password = mysqli_real_escape_string($conn, $_POST['alumni_password']);

	//Encrypt Password
	$alumni_password = base64_encode(strrev(md5($alumni_password)));

	//sql query to check user login
	$sql = "SELECT alumni_firstname, alumni_lastname, alumni_email, alumni_active FROM alumni WHERE alumni_email='$alumni_email' AND alumni_password='$alumni_password'";
	$result = $conn->query($sql);

	//if user table has this this login details
	if($result->num_rows > 0) {
		//output data
		while($row = $result->fetch_assoc()) {

			if($row['alumni_active'] == '0') {
				$_SESSION['loginActiveError'] = "Your Account Is Not Active. Contact Admin.";
		 		header("Location: login-alumni.php");
				exit();
			} else if($row['alumni_active'] == '1') { 

				//Set some session variables for easy reference
				$_SESSION['alumni_name'] = $row['alumni_firstname'] . " " . $row['alumni_lastname'];
				$_SESSION['alumni_email'] = $row['alumni_email'];

				if(isset($_SESSION['callFrom'])) {
					$location = $_SESSION['callFrom'];
					unset($_SESSION['callFrom']);
					
					header("Location: " . $location);
					exit();
				} else {
					header("Location: alumni/index.php");
					exit();
				}
			} else if($row['alumni_active'] == '2') { 

				$_SESSION['loginActiveError'] = "Your Account Is Deactivated. Contact Admin To Reactivate.";
		 		header("Location: login-alumni.php");
				exit();
			}

			//Redirect them to user dashboard once logged in successfully
			
		}
 	} else {

 		//if no matching record found in user table then redirect them back to login page
 		$_SESSION['loginError'] = $conn->error;
 		header("Location: login-alumni.php");
		exit();
 	}

 	//Close database connection. Not compulsory but good practice.
 	$conn->close();

} else {
	//redirect them back to login page if they didn't click login button
	header("Location: login-alumni.php");
	exit();
}