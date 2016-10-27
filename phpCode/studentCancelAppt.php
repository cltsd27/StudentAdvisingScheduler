<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

// HTML head
include("../public_html/head.html");

$student= mysql_real_escape_string($_SESSION["key"]);

//query to check if student already has an appointment
$currentAppointment = "SELECT * FROM `Appointment` WHERE `Stu1` = " . $student;
for($i = 2;$i<=10; $i+=1)
{
  $currentAppointment = $currentAppointment. " OR `Stu".$i."` = " .$student;
}

$results = $COMMON->executeQuery($currentAppointment, $_SERVER["SCRIPT_NAME"]);

//if there is an appointment print it and give a delete option
if($rows = mysql_fetch_array($results))
{
  // gather advisor infor from current appointment
  $query = "SELECT * FROM `Adviser` WHERE `Key` =".$rows['Adviser'];
  $staffRS = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
  $staffInfo  = mysql_fetch_array($staffRS);

  //get all nessesery data from all queries
  $advisor = ($staffInfo['FirstName']. " ".$staffInfo['LastName']);
  $isGroup = $rows['IsGroup'];
  $location = $rows['Location'];
  $date = $rows['Date'];
  $time = $rows['Time'];
  $appoitment= $rows['Key'];
  $stuNum;
  
  //find which student in the list of 10 is the current one
  for($i = 1;$i<=10; $i++)
  {
    if($student == $rows['Stu'.$i]){$stuNum = $i;}
  }
  
  echo("<div class=\"title\"> <h2>Cancel Appointment</h2> </div>");
  echo("<div class=\"content\">");

  //print info about appointment
  echo ("<p>Delete this Appointment:<br>");
  if($isGroup){
    echo ("Group ");
  }
  else{
    echo ("Individual ");}
  
  echo("<br>Adviser: ".$advisor. "<br>Location: ".$location."<br>Date: ".$date."<br>Time: ".$time . "</p>");

  //Delete appointment button
  echo ("<form method=\"POST\" action=''>");

  echo("<input type=\"submit\" name=\"deleteButton\"  value=\"Delete Appointment\">");
  echo("</form>");
  
  //Menu button
  echo("<br><a href=\"../public_html/studentHome.html\">Student Home</a>");

  //if the delete button is pressed
  if (isset($_POST['deleteButton'])){

    $num  = $rows['NumStu'];

    $updateQuery = ("UPDATE `Appointment` SET ");
    
    //delete the current student from the appointment, shift all students after one over and incriment down the number of students by 1
    for($i = $stuNum;$i <=($num-1);$i++)
    {
      $updateQuery =($updateQuery." `Stu".$i."` = ".$rows['Stu'.($i+1)].",");
    }
    $updateQuery =($updateQuery." `Stu".$num."` = NULL, `NumStu` = ".($num-1)." WHERE `Key` = ".$appoitment); 


    $COMMON->executeQuery($updateQuery, $_SERVER["SCRIPT_NAME"]);
    //go to the menu screen after
    header("Location:  ../public_html/studentHome.html");
    exit();
    }

}
//if no appointment has been set up go to the view appointment page to let the student know no appointment has been created thus far
else{
     header("Location: studentViewAppt.php");
     exit();
}

// HTML tail 
include('../public_html/tail.html');

?>
