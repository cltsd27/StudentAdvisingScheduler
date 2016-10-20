<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

//$student= mysql_real_escape_string($_SESSION["key"]);

$student = 1;


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
  $appoitment= $rows['Key'];
  $stuNum;
  
  for($i = 1;$i<=10; $i++)
  {
    if($student == $rows['Stu'.$i]){$stuNum = $i;}
  }


  echo ("Delete this Appointment:<br><br>");
  if($isGroup){
    echo ("Group ");
  }
  else{
    echo ("Individual ");}
  
  echo("<br>Adviser: ".$advisor. "<br>Location: ".$location."<br>Date: ".$date."<br>Time: ".$time);

  echo ("<br><br><form method=\"POST\" action=''>");

  echo("<br><input type=\"submit\" name=\"deleteButton\"  value=\"Delete Appointment\">");
  echo("</form>");

  if (isset($_POST['deleteButton'])){

    $num  = $rows['NumStu'];

    $updateQuery = ("UPDATE `Appointment` SET ");

    for($i = $stuNum;$i <=($num-1);$i++)
    {
      $updateQuery =($updateQuery." `Stu".$i."` = ".$rows['Stu'.($i+1)].",");
    }
    $updateQuery =($updateQuery." `Stu".$num."` = NULL, `NumStu` = ".($num-1)." WHERE `Key` = ".$appoitment); 


    $COMMON->executeQuery($updateQuery, $_SERVER["SCRIPT_NAME"]);
    header("Location:  ../public_html/studentHome.html");
    exit();
    }

}
else{
     header("Location: studentViewAppt.php");
     exit();
}

?>
