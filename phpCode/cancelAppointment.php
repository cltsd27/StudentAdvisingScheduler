<?php

include("VerifySession.php");
include("CommonMethods.php");
$verify = "staffID";
$redirect = "https://swe.umbc.edu/~michris1/CMSC331/advisingProjectPt1/public_html/staffSignIn.html";

$VERIFY = new Verify($verify, $redirect);
$VERIFY->verifySession();


$key = $_SESSION["key"];
$queryAppointments = "SELECT * FROM `meetings` WHERE advisor = $key";
$debug = false;
$COMMON = new Common($debug);
$rs = $COMMON->executeQuery($queryAppointments, $_SERVER["SCRIPT_NAME"]);

echo("<html>
<head>
</head>
<body>
<form method=\"post\" action=\"appontmentCancel.php\">
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

while($row = mysql_fetch_row($rs)){
  echo("<tr>\n");
  if($row[2] == "1"){
    echo("  <td>Yes</td>\n");
  } else {
    echo("  <td>No</td>\n");
  }
  echo("  <td>$row[4]</td>\n");
  $date = substr($row[5], 5, 5);
  echo("  <td>$date</td>\n");
  $time = substr($row[5], 11, 5);
  echo("  <td>$time</td>\n");
  if($row[3] == "0"){
    echo("  <td>None</td>\n");
  }
  echo("  <td><input type=\"checkbox\" value=\"$row[0]\"></td>\n");
  echo("</tr>\n");
}
echo("</table>
<input type=\"submit\" value=\"Submit\">
</form>
</body>");
?>