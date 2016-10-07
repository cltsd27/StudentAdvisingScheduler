<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

//$student= mysql_real_escape_string($_SESSION["key"]);

$student = 1;

$currentAppointment = "SELECT * FROM `meetings` WHERE `student1` = " . $student;
for($i = 2;$i<=10; $i+=1)
{
  $currentAppointment = $currentAppointment. " OR `student".$i."` = " .$student;
}

$results = $COMMON->executeQuery($currentAppointment, $_SERVER["SCRIPT_NAME"]);

if($rows = mysql_fetch_array($results))
{

  $query = "SELECT * FROM `staff` WHERE `key` =".$rows['advisor'];
  $staffRS = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
  $staffInfo  = mysql_fetch_array($staffRS);

  $advisor = ($staffInfo['fname']. " ".$staffInfo['lname']);
  $isGroup = $rows['isGroup'];
  $location = $rows['location'];
  $dateTime = $rows['dateTime'];

  echo ("You already have an appointment:<br>\t");
  if($isGroup){
    echo ("Group ". str_repeat("&nbsp;", 10));
  }
  else{
    echo ("Individual ".str_repeat("&nbsp;", 5));}
  
  echo(" with ".$advisor. " in ".$location." at ". $dateTime.".");

}
else
{
  $query = "SELECT * FROM `meetings` WHERE `numStudentsRegistered` = 0 OR (`isGroup`= 1 AND `numStudentsRegistered` < 10)";
  $results = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);

  if($rows = mysql_fetch_array($results)){
    echo ("Availible appointments are:<br>\t"); 

    echo ("<table>");

    do{
      $query = "SELECT * FROM `staff` WHERE `key` =".$rows['advisor'];
      $staffRS = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
      $staffInfo  = mysql_fetch_array($staffRS);

      $key = $rows['key'];
      $advisor = ($staffInfo['fname']. " ".$staffInfo['lname']);                                               
      $isGroup = $rows['isGroup'];                                                
      $location = $rows['location'];                                            
      $dateTime = $rows['dateTime'];                                          
      
      if($isGroup){                                                       
	$group = "Group";                                 
      }                                                               
      else{                 
	$group = "Individual";}

      echo ("<tr><td>". $group."</td><td>".str_repeat("&nbsp;", 10)."</td>"."<td>". $advisor."</td><td>".str_repeat("&nbsp;", 2)."</td>".
	    "<td>". $location."</td><td>".str_repeat("&nbsp;", 2)."</td>"."<td>". $dateTime."</td><td>".str_repeat("&nbsp;", 2)."</td>".
	    "<td><input type=\"radio\" name=\"appoitment\" value=\"".$key."\"></td></tr>");

    } while ($rows = mysql_fetch_array($results));
    
    echo ("</table>");
  
  }
  else{
    echo ("Sorry there are no appointments availible at this time<br>\t");
  }
}

?>
