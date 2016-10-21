<?php

include("VerifySession.php");
include("CommonMethods.php");
$verify = "staffID";
$redirect = "https://swe.umbc.edu/~michris1/CMSC331/advisingProjectPt1/public_html/staffSignIn.html";

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
header("Location: https://swe.umbc.edu/~michris1/CMSC331/advisingProjectPt1/phpCode/adviserCancelApptForm.php");