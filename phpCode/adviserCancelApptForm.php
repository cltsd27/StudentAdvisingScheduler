<?php

include("VerifySession.php");
include("CommonMethods.php");
$verify = "staffID";
$redirect = "https://swe.umbc.edu/~michris1/CMSC331/advisingProjectPt1/public_html/staffSignIn.html";

$VERIFY = new Verify($verify, $redirect);
$VERIFY->verifySession();


$key = $_SESSION["key"];
$queryAppointments = "SELECT * FROM `Appointment` WHERE `Adviser` = $key";
$debug = false;
$COMMON = new Common($debug);
$rs = $COMMON->executeQuery($queryAppointments, $_SERVER["SCRIPT_NAME"]);
//build top html and table header
echo("<html>
<head>
</head>
<body>
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
<a href='../public_html/adviserHome.html'> Home </a>
</body>
</html>");

?>