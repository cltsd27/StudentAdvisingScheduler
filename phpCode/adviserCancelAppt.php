<?php
/*
File:	 adviserCancelAppt.php
Project: CMSC 331 Project 1
Author:	 Christopher Mills 
Date:	 10/8/16

         This file creates the query to delete appointment(s) and then 
	 redirects back to the cancel appointment form page
*/

//verify that the current user is logged in as a staff member
include("VerifySession.php");
include("CommonMethods.php");
$verify = "staffID";
$redirect = "../public_html/staffSignIn.html";

$VERIFY = new Verify($verify, $redirect);
$VERIFY->verifySession();
$debug = false;
$COMMON = new Common($debug);

//delete every meeting checked
foreach($_POST as $val){
  $deleteQuery = "DELETE FROM `Appointment` WHERE `key` = $val";
  $COMMON->executeQuery($deleteQuery, $_SERVER["SCRIPT_NAME"]);
}

//redirect to cancelAppointment page
header("Location: adviserCancelApptForm.php");