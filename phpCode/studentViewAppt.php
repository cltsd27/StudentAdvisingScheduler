<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

// HTML head
include("../public_html/head.html");

$student= mysql_real_escape_string($_SESSION["key"]);


$currentAppointment = "SELECT * FROM `Appointment` WHERE `Stu1` = " . $student;
for($i = 2;$i<=10; $i+=1)
{
  $currentAppointment = $currentAppointment. " OR `Stu".$i."` = " .$student;
}

$results = $COMMON->executeQuery($currentAppointment, $_SERVER["SCRIPT_NAME"]);

echo("<div class=\"title\"> <h2>View Appointment</h2> </div>");
echo("<div class=\"content\">");

if($rows = mysql_fetch_array($results))
{

  $query = "SELECT * FROM `Adviser` WHERE `Key` =".$rows['Adviser'];
  $staffRS = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
  $staffInfo  = mysql_fetch_array($staffRS);

  $advisor = ($staffInfo['FirstName']. " ".$staffInfo['LastName']);
  $isGroup = $rows['IsGroup'];
  $location = $rows['Location'];
  $date = $rows['Date'];
  $time = $rows['Time'];

  echo ("You have an appointment set up:<br><br>");
  if($isGroup){
    echo ("Group ");
  }
  else{
    echo ("Individual ");}
  
  echo("<br>Adviser: ".$advisor. "<br>Location: ".$location."<br>Date: ".$date."<br>Time: ".$time);
  echo("<br><br>");

}
else{
    echo ("Sorry you do not have an appointment yet.<br><br>");
}

  
echo("<a href=\"../public_html/studentHome.html\">Student Home</a>");


// HTML tail 
include('../public_html/tail.html');

?>
