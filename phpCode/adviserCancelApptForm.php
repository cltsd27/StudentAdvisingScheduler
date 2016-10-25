<?php
/*
File:	 adviserCancelApptForm.php
Project: CMSC 331 Project 1
Author:	 Christopher Mills
Date:	 10/8/16

         This is the form that an adviser uses to choose appointment(s) to delete
*/

// Verify that the user is logged in as a staff member
include("VerifySession.php");
include("CommonMethods.php");
$verify = "staffID";
$redirect = "../public_html/staffSignIn.html";

$VERIFY = new Verify($verify, $redirect);
$VERIFY->verifySession();

//query database for appointments that belong to the logged in adviser
$key = $_SESSION["key"];
$queryAppointments = "SELECT * FROM `Appointment` WHERE `Adviser` = $key";
$debug = false;
$COMMON = new Common($debug);
$rs = $COMMON->executeQuery($queryAppointments, $_SERVER["SCRIPT_NAME"]);

// HTML Head
include("../public_html/head.html");

// HTML/CSS styling
echo("<div class=\"title\"> <h2>Cancel Appointment</h2> </div>");
echo("<div class=\"content\">");

//build table header
echo("
<form method=\"post\" action=\"adviserCancelAppt.php\">
<table>
<tr>
  <th>Group</th>
  <th>Location</th>
  <th>Date</th>
  <th>Time</th>
  <th>Registered Students</th>
  <th>Delete</th>
</tr>
");

//populate table data
while($row = mysql_fetch_row($rs)){
  echo("<tr>\n");
  if($row[5] == "1"){
    echo("  <td>Yes</td>\n");
  } else {
    echo("  <td>No</td>\n");
  }
  echo("  <td>$row[2]</td>\n");
  echo("  <td>$row[3]</td>\n");
  echo("  <td>$row[4]</td>\n");
  if($row[6] == "0"){
    echo("  <td>None</td>\n");
  } else {
    echo("  <td>");
    for($i = 7; $i < 17; $i++){
      if(isset($row[$i])){
	$getStudentQuery = "SELECT `FirstName`, `LastName` from `Student` WHERE `Key` = $row[$i]";
	$rs2 = $COMMON->executeQuery($getStudentQuery, $_SERVER["SCRIPT_NAME"]);
	$studentRow = mysql_fetch_row($rs2);
	echo("$studentRow[0] $studentRow[1], ");
      } else {
	echo("</td>\n");
	break;
      }
    }
  }
  echo("  <td><input type=\"checkbox\" name=\"$row[0]\" value=\"$row[0]\"></td>\n");
  echo("</tr>\n");
}

//end html
echo("</table>
<input type=\"submit\" value=\"Submit\">
</form>
<br><a href='../public_html/adviserHome.html'>Adviser Home </a>");

// HTML Tail
include('../public_html/tail.html');

?>