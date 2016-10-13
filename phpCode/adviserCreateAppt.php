<?php

session_start();

include('./CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

$advisor = mysql_real_escape_string($_SESSION["key"]);
$isGroup = isset($_POST["cbIsGroup"]) ? 1 : 0;
$location = mysql_real_escape_string($_POST["tfLocation"]);
$date = mysql_real_escape_string($_POST["date"]);
$time = mysql_real_escape_string($_POST["rbTime"]);
$dateTime = $date . " " . $time . ":00";

$insertMeetingQuery = "INSERT INTO `Appointment` (`key`, `advisor`, `isGroup`, `numStudentsRegistered`, `location`, `dateTime`) VALUES ('', $advisor, $isGroup, 0, '$location', '$dateTime')";
$COMMON->executeQuery($insertMeetingQuery, $_SERVER["SCRIPT_NAME"]);

?>
<html>
<head>
  <title>Meeting Created</title>
  <link rel="stylesheet" type="text/css" href="../public_html/advising.css">
</head>
<body>
  <h2>Meeting created!</h2>
  <p>Redirecting back to home page</p>
</body>
</html>

