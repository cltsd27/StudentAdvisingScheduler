<?php
$debug = false;
include('CommonMethods.php');
include('VerifySession.php');
$COMMON = new Common($debug);

$verify = "studID";
$redirect = "https://swe.umbc.edu/~michris1/CMSC331/advisingProjectPt1/public_html/studentSignIn.html";
$VERIFY = new Verify($verify, $redirect);
$VERIFY->verifySession();


$student= mysql_real_escape_string($_SESSION["key"]);

$currentAppointment = "SELECT * FROM `Appointment` WHERE `Stu1` = " . $student;
for($i = 2;$i<=10; $i+=1)
{
  $currentAppointment = $currentAppointment. " OR `Stu".$i."` = " .$student;
}

$results = $COMMON->executeQuery($currentAppointment, $_SERVER["SCRIPT_NAME"]);

if($rows = mysql_fetch_array($results))
{

  $query = "SELECT * FROM `Adviser` WHERE `key` =".$rows['Adviser'];
  $staffRS = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
  $staffInfo  = mysql_fetch_array($staffRS);

  $advisor = ($staffInfo['FirstName']. " ".$staffInfo['LastName']);
  $isGroup = $rows['IsGroup'];
  $location = $rows['Location'];
  $date = $rows['Date'];
  $time = $rows['Time'];

  echo ("You already have an appointment:<br><br>");
  if($isGroup){
    echo ("Group ");
  }
  else{
    echo ("Individual ");}
  
  echo("<br>Adviser: ".$advisor. "<br>Location: ".$location."<br>Date: ".$date."<br>Time: ".$time);

}
else
{
  $query = "SELECT * FROM `Appointment` WHERE `NumStu` = 0 OR (`IsGroup`= 1 AND `NumStu` < 10)";
  $results = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);

  if($rows = mysql_fetch_array($results)){
    echo ("Availible appointments are:<br>\t"); 

    echo ("<table>");

    do{
      $query = "SELECT * FROM `Adviser` WHERE `key` =".$rows['Adviser'];
      $staffRS = $COMMON->executeQuery($query, $_SERVER["SCRIPT_NAME"]);
      $staffInfo  = mysql_fetch_array($staffRS);

      $key = $rows['Key'];
      $advisor = ($staffInfo['FirstName']. " ".$staffInfo['LastName']);                                               
      $isGroup = $rows['IsGroup'];                                                
      $location = $rows['Location'];                                            
      $date = $rows['Date'];
      $time = $rows['Time'];      

      if($isGroup){                                                       
	$group = "Group";                                 
      }                                                               
      else{                 
	$group = "Individual";}

      echo ("<tr><td>". $group."</td><td>".str_repeat("&nbsp;", 10)."</td>"."<td>". $advisor."</td><td>".str_repeat("&nbsp;", 2)."</td>".
	    "<td>". $location."</td><td>".str_repeat("&nbsp;", 2)."</td>"."<td>". $date."</td><td>".str_repeat("&nbsp;", 2)."</td>"."<td>".
	    $time."</td><td>".str_repeat("&nbsp;", 2)."</td><td><input type=\"radio\" name=\"appoitment\" value=\"".$key."\"></td></tr>");

    } while ($rows = mysql_fetch_array($results));
    
    echo ("</table>");
  
  }
  else{
    echo ("Sorry there are no appointments availible at this time<br>\t");
  }
}

?>
