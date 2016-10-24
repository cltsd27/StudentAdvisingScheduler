<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

$student= mysql_real_escape_string($_SESSION["key"]);

//$student = 1;


$currentAppointment = "SELECT * FROM `Appointment` WHERE `Stu1` = " . $student;
for($i = 2;$i<=10; $i+=1)
{
  $currentAppointment = $currentAppointment. " OR `Stu".$i."` = " .$student;
}

$results = $COMMON->executeQuery($currentAppointment, $_SERVER["SCRIPT_NAME"]);

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

}
else{
    echo ("Sorry you do not have an appointment yet<br>\t");
}

  
  echo ("<br><br><form action='../public_html/studentHome.html'>");

  echo("<br><input type=\"submit\" name=\"menuButton\"  value=\"Menu\">");
  echo("</form>");




?>
