<?php
/* 
File:	 adviserApptViewer.php
Project: CMSC 331 Project 1
Author:	 Elizabeth Aucott 
Date:	 10/8/16

		 This is the php file to fetch and display adviser appointments. 

*/ 
include('../public_html/head.html');

include('../CommonMethods.php');
$debug = false;
$COMMON = new Common($debug); 

$date = $_POST['datePickedDay'];

$sql = "SELECT * FROM `Appointment` WHERE `Date`='$date' ORDER BY `Time`"; // Need to add AND adviserkey
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

echo("<div class=\"title\"> <h2>View Appointments</h2> </div>");
echo("<div class=\"content\">");

// Print out date in nice format 
date_default_timezone_set('America/New_York');
$date = date_create($date);
echo(date_format($date, 'l, F jS, Y'));
echo("<br>");

// If appointments found on date, print them out in a table
if (mysql_num_rows($rs) > 0) {
	echo("<table>");
	echo("<tr>");
	echo("<th>Time</th>");
	echo("<th>Location</th>");
	echo("<th>Type</th>");
	echo("<th>Student</th>");
	echo("</tr>");
	
	// Print out all appointments found on that date 
	while ($row = mysql_fetch_assoc($rs)) {
		echo("<tr>");
		echo ("<td>" . convertTime($row['Time']) . "</td>\n");
		echo ("<td>" . $row['Location'] . "</td>\n");
		
		// Print out group vs individual type 
		if ($row['IsGroup']) {
			echo ("<td>Group</td>\n");
		}
		else {
			echo ("<td>Individual</td>\n");
		}
		
		// Print out all the students in appointment
		// Do not do a query for student names if no one signed up yet 
		//		(because it throws an sql error)
		if($row['NumStu'] > 0) {
			echo ("<td>" . getStudentName($row['Stu1']));
			for ($i = 1; $i < $row['NumStu']; $i++) {
				$stuIndex = 'Stu' . ($i + 1);
				echo("<br><p>" . getStudentName($row[$stuIndex]) . "</p>");
			}
			echo("</td>");
		}
		// Print an empty table box if no students signed up
		else {
			echo("<td></td>");
		}
		
		echo("</tr>");
	}
	
	echo("</table>");
}
// If no appointments found, let adviser know 
else {
	echo("<p>There are no appointments scheduled on this date.<br><br></p>");
}


// Links to view another appointment or go back to home
echo("<p><br></p> <a href=\"../public_html/adviserViewAppt.html\">View Another Appointment</a> <p><br></p>");
echo("<a href=\"../public_html/adviserHome.html\">Adviser Home</a> <p><br></p>");

echo("</div>");

include('../public_html/tail.html');


// getStudentName runs another sql query 
// 		to find the first and last name of the student with stuKey 
function getStudentName($stuKey) {
	global $debug; global $COMMON;
	$sql = "SELECT * FROM `Student` WHERE `Key`=$stuKey";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	$row = mysql_fetch_assoc($rs);
	return($row['FirstName'] . " " . $row['LastName']);
}

// converTime converts a string in the format HH:MM:SS
// 		to a string in the format HH:MM AM/PM
function convertTime($time) {
	$hours = intval($time[0] . $time[1]);
	$minutes = $time[3] . $time[4];
	
	// 12:00 PM
	if ($hours == 12) {
		$period = "PM";
	}
	// 12:00 AM
	else if ($hours == 24) {
		$hours = $hours - 12;
		$period = "AM";
	}
	// PM
	else if ($hours > 12) {
		$hours = $hours - 12;
		$period = "PM";
	}
	// AM
	else {
		$period = "AM";
	}
	
	return($hours . ":" . $minutes . " " . $period);
}
?>