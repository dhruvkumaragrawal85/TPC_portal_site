<?php

//To Handle Session Variables on This Page
session_start();

if (empty($_SESSION['alumni_email'])) {
	header("Location: ../index.php");
	exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

//if user Actually clicked update profile button
if (isset($_POST)) {

	//Escape Special Characters
	$alumni_firstname = mysqli_real_escape_string($conn, $_POST['alumni_firstname']);
	$alumni_lastname = mysqli_real_escape_string($conn, $_POST['alumni_lastname']);
	$alumni_company = mysqli_real_escape_string($conn, $_POST['alumni_company']);
	$alumni_ctc = mysqli_real_escape_string($conn, $_POST['alumni_ctc']);
	$alumni_email = mysqli_real_escape_string($conn, $_POST['alumni_email']);
	$alumni_address = mysqli_real_escape_string($conn, $_POST['alumni_address']);
	$alumni_mob = mysqli_real_escape_string($conn, $_POST['alumni_mob']);
	$alumni_dob = mysqli_real_escape_string($conn, $_POST['alumni_dob']);
	$alumni_qualification = mysqli_real_escape_string($conn, $_POST['alumni_qualification']);
	$alumni_stream = mysqli_real_escape_string($conn, $_POST['alumni_stream']);
	$alumni_passingyear = mysqli_real_escape_string($conn, $_POST['alumni_passingyear']);
	$alumni_cpi = mysqli_real_escape_string($conn, $_POST['alumni_cpi']);

	// $aboutme = mysqli_real_escape_string($conn, $_POST['aboutme']);
	// $PG = mysqli_real_escape_string($conn, $_POST['pg']);

	// $uploadOk = true;

	// if (isset($_FILES)) {

	// 	$folder_dir = "../uploads/resume/";

	// 	$base = basename($_FILES['resume']['name']);

	// 	$resumeFileType = pathinfo($base, PATHINFO_EXTENSION);

	// 	$file = uniqid() . "." . $resumeFileType;

	// 	$filename = $folder_dir . $file;

	// 	if (file_exists($_FILES['resume']['tmp_name'])) {

	// 		if ($resumeFileType == "pdf") {

	// 			if ($_FILES['resume']['size'] < 500000) { // File size is less than 5MB

	// 				move_uploaded_file($_FILES["resume"]["tmp_name"], $filename);
	// 			} else {
	// 				$_SESSION['uploadError'] = "Wrong Size. Max Size Allowed : 5MB";
	// 				header("Location: edit-profile.php");
	// 				exit();
	// 			}
	// 		} else {
	// 			$_SESSION['uploadError'] = "Wrong Format. Only PDF Allowed";
	// 			header("Location: edit-profile.php");
	// 			exit();
	// 		}
	// 	}
	// } else {
	// 	$uploadOk = false;
	// }



	$sql = "UPDATE alumni SET alumni_firstname='$alumni_firstname', alumni_lastname='$alumni_lastname', alumni_address='$alumni_address', alumni_company='$alumni_company', alumni_ctc='$alumni_ctc', alumni_mob='$alumni_mob', alumni_qualification='$alumni_qualification', alumni_stream='$alumni_stream', alumni_dob='$alumni_dob', alumni_cpi='$alumni_cpi',  alumni_ctc='$alumni_ctc', alumni_mob='$alumni_mob'";
	//Update User Details Query

	// if ($uploadOk == true) {
	// 	$sql .= ", resume='$file'";
	// }
	$sql .= " WHERE alumni_email='$_SESSION[alumni_email]'";
	if ($conn->query($sql) === TRUE) {
		// $_SESSION['name'] = $firstname . ' ' . $lastname;
		//If data Updated successfully then redirect to dashboard
		header("Location: index.php");
		exit();
	} else {
		echo "Error " . $sql . "<br>" . $conn->error;
	}
	//Close database connection. Not compulsory but good practice.
	$conn->close();
} else {
	//redirect them back to dashboard page if they didn't click update button
	header("Location: edit-profile.php");
	exit();
}
