<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

//$student= mysql_real_escape_string($_SESSION["key"]);

$student = 2;

$currentAppointment = "SELECT * FROM `meetings` WHERE `student1` = " . $student;
for($i = 2;$i<=10; $i+=1)
{
  $currentAppointment = $currentAppointment. " OR `student".$i."` = " .$student;
}

$results = $COMMON->executeQuery($currentAppointment, $_SERVER["SCRIPT_NAME"]);

if($rows = mysql_fetch_array($results))
{
  while ($rows = mysql_fetch_array($results)){
    $advisor = $rows['advisor'];
    $isGroup = $rows['isGroup'];
    $location = $rows['location'];
    $dateTime = $rows['dateTime'];

    echo ("You already have an appointment:<br>\t");
    if($isGroup){
      echo ("Group ");
    }
    else{
      echo ("Individual ");}

    echo("with ". $advisor. " in ".$location." at ". $dateTime.".");

  }

}
else
{
  $query = "SELECT * FROM `meetings` WHERE `numStudentsRegistered` = 0";
  $results = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);

  echo ("Availible appointments are:<br>\t"); 

  while ($rows = mysql_fetch_array($results)){   
    $key = $rows['key'];
    $advisor = $rows['advisor'];                                                  
    $isGroup = $rows['isGroup'];                                                
    $location = $rows['location'];                                            
    $dateTime = $rows['dateTime'];                                          
      
    if($isGroup){                                                       
      echo ("Group ");                                                  
    }                                                               
    else{                 
      echo ("Individual ");}  
    echo("with ". $advisor. " in ".$location." at ". $dateTime.".");
    echo("<input type=\"radio\" name=\"appoitment\" value=\"".$key."\"><br>");
  }  
}

?>
