<?php
session_start();
$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug);

$student= mysql_real_escape_string($_SESSION["key"]);

//$student = 6;

$createAppointment = false;

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

  echo ("<br><br><form action='../public_html/studentHome.html'>");

  echo("<br><input type=\"submit\" name=\"menuButton\"  value=\"Menu\">");
  echo("</form>");

}
else
{
  $query = "SELECT * FROM `Appointment` WHERE `NumStu` = 0 OR (`IsGroup`= 1 AND `NumStu` < 10)";
  $results = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);

  if($rows = mysql_fetch_array($results)){
    $createAppointment = true;
    echo ("Availible appointments are:<br><br>"); 
    echo("<form method=\"POST\" action=''>");

    echo ("<table>");

    do{
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

      if($isGroup){                                                       
	$group = "Group";                                 
      }                                                               
      else{                 
	$group = "Individual";}

      echo ("<tr><td>". $group."</td><td>".str_repeat("&nbsp;", 10)."</td>"."<td>". $advisor."</td><td>".str_repeat("&nbsp;", 2)."</td>".
	    "<td>". $location."</td><td>".str_repeat("&nbsp;", 2)."</td>"."<td>". $date."</td><td>".str_repeat("&nbsp;", 2)."</td>"."<td>".
	    $time."</td><td>".str_repeat("&nbsp;", 2)."</td><td><input type='radio' name='appoitment' value='".$key."'></td></tr>");

    } while ($rows = mysql_fetch_array($results));
    
    echo ("</table>");

    echo("<br><input type=\"submit\" name=\"submitButton\"  value=\"Submit\">");
    echo("</form>");
  
  }
  else{
    echo ("Sorry there are no appointments availible at this time<br>\t");
  }

  
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
    header("Refresh:0");
    }


}

?>
