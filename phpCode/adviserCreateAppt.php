<?php

session_start();

include('./CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

$advisor = mysql_real_escape_string($_SESSION["key"]);
$isGroup = isset($_POST["cbIsGroup"]) ? 1 : 0;
$location = mysql_real_escape_string($_POST["tfLocation"]);
$date = mysql_real_escape_string($_POST["date"]);
$time = mysql_real_escape_string($_POST["Time"]);

$insertMeetingQuery = "INSERT INTO `Appointment` (`Key`, `Adviser`, `IsGroup`, `NumStu`, `Location`, `Date`, `Time`) VALUES ('', $advisor, $isGroup, 0, '$location', '$date', '$time')";
$COMMON->executeQuery($insertMeetingQuery, $_SERVER["SCRIPT_NAME"]);

// HTML Head
include("../public_html/head.html");

// HTML/CSS styling
echo("<div class=\"title\"> <h2>Create Appointment</h2> </div>");
echo("<div class=\"content\">");


// Do not create appointment if Date or Location field empty
if ($location == "" || $date == "") {
    echo("<p>Invalid appointment.</p>");
}
// Successfully create appointment
else {
    $insertMeetingQuery = "INSERT INTO `Appointment` (`Key`, `Adviser`, `IsGroup`, `NumStu`, `Location`, `Date`, `Time`) VALUES ('', $advisor, $isGroup, 0, '$location', '$date', '$time')";
    $rs = $COMMON->executeQuery($insertMeetingQuery, $_SERVER["SCRIPT_NAME"]);

    // Print out information from appointment just created
    echo("<p>Appointment Created!<br><br>");
    echo("$date    $time<br>");
    echo("$location    ");

    if ($isGroup) {
        echo("Group<br></p>");
    }
    else {
        echo("Individual<br></p>");
    }
}

// Links to make another appointment or go back to home
echo("<p><br></p> <a href=\"../phpCode/adviserCreateApptForm.php\">Create Appointment</a> <p><br></p>");
echo("<a href=\"../public_html/adviserHome.html\">Adviser Home</a> <p><br></p>");

echo("</div>");

// HTML Tail
include('../public_html/tail.html');

?>