<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

// HTML head
include("../public_html/head.html");

$student= mysql_real_escape_string($_SESSION["key"]);

//checks number of appointments
$numApp = 0;

//checks if student already has an appointment created
$currentAppointment = "SELECT * FROM `Appointment` WHERE `Stu1` = " . $student;
for($i = 2;$i<=10; $i+=1)
{
  $currentAppointment = $currentAppointment. " OR `Stu".$i."` = " .$student;
}

$results = $COMMON->executeQuery($currentAppointment, $_SERVER["SCRIPT_NAME"]);

//if an appointment exists redirect to view appointment
if($rows = mysql_fetch_array($results))
{
  header("Location: studentViewAppt.php");
  exit();
}
//otherwise find availible appointments
else
{
  $query = "SELECT * FROM `Appointment` WHERE `NumStu` = 0 OR (`IsGroup`= 1 AND `NumStu` < 10)";
  $results = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);

  $query = "SELECT `Major` FROM `Student` WHERE `Key` = ".$student." lIMIT 1";
  $getMajor = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
  $major  = mysql_result($getMajor,0);

  if($rows = mysql_fetch_array($results)){
    // HTML styling 
    echo("<div class=\"title\"> <h2>Sign Up for an Appointment</h2> </div>");
    echo("<div class=\"content\">");
    
    echo ("Availible appointments are:<br><br>"); 
    echo("<form method=\"POST\" action=''>");
    // using a table gather all important information about the appointment and aquire the advisors name
    // and display in a table with radio buttons
    echo ("<table>");

    do{
      //aquire advisors name
      $query = "SELECT * FROM `Adviser` WHERE `Key` =".$rows['Adviser'];
      $staffRS = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
      $staffInfo  = mysql_fetch_array($staffRS);

      $key = $rows['Key'];
      $advisor = ($staffInfo['FirstName']. " ".$staffInfo['LastName']);                                               
      $isGroup = $rows['IsGroup'];                                                
      $location = $rows['Location'];                                            
      $date = $rows['Date'];
      $time = $rows['Time'];     
      $numSt = $rows['NumStu'];

      $dep = $staffInfo['Department'];

      if($isGroup){                                                       
        $group = "Group";                                 
      }                                                               
      else{                 
        $group = "Individual";
      }

      //only print the appointment if the major and epartment match
      $csee = ($major == "CMSC" || $major == "CMPE") && $dep == "CSEE";
      $biol = (preg_match('/BIOL/',$major) || $major == "BIOC" || $major == "BINF" || $major == "BIOE") && $dep == "BIOL";
      $chem = (preg_match('/CHEM/',$major)  || $major == "CHED") && $dep == "CHEM";

      if($biol || $csee ||$chem){
        $numApp++;
     
        echo ("<tr><td>" . $group. "</td><td>" . $advisor . "</td><td>" . $location . "</td><td>" . $date."</td><td>" . $time . "</td><td><input type='radio' name='appoitment' value='\".$key.\"'></td></tr>");
      }
    } while ($rows = mysql_fetch_array($results));
    
    
    echo ("</table>");
    
    echo("<input type=\"submit\" name=\"submitButton\"  value=\"Submit\"><br><br>");
    echo("</form>");
    
    echo("<a href=\"../public_html/studentHome.html\">Student Home</a>");
  }

  //after selecting an appointment you can submit it to the data base
  if (isset($_POST['submitButton'])){
    $selected = $_POST['appoitment'];

    $query = "SELECT `NumStu` FROM `Appointment` WHERE `Key` = ".$selected." lIMIT 1";
    $setApp = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
    $num  = mysql_result($setApp,0);
    $num++;


    $updateQuery = ("UPDATE `Appointment` SET `Stu".$num."` = ". $student. " WHERE `Key` = ".$selected);
    $COMMON->executeQuery($updateQuery, $_SERVER["SCRIPT_NAME"]);
    
    $updateQuery = ("UPDATE `Appointment` SET `NumStu` = ".$num. " WHERE `Key` = ".$selected);
    $COMMON->executeQuery($updateQuery, $_SERVER["SCRIPT_NAME"]);
    //refresh page
    header("Refresh:0");
    }

  //if no appointment exist state so
  if($numApp == 0){
    echo ("Sorry there are no appointments availible at this time<br>\t");
    echo("<form method=\"POST\" action='../public_html/studentHome.html'>"); 
    echo("<br><input type=\"submit\" name=\"backButton\"  value=\"Back\">");
    echo("</form>");

  }

}

// HTML tail 
include('../public_html/tail.html');

?>
