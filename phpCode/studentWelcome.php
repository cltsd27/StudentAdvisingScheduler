<?php

include('./CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

$fName = mysql_real_escape_string($_POST["fName"]);
$lName = mysql_real_escape_string($_POST["lName"]);
$studID = mysql_real_escape_string(strtolower($_POST["studID"]));
$email = mysql_real_escape_string($_POST["email"]);
$major = mysql_real_escape_string($_POST["major"]);


$queryForExistingUser = "SELECT * FROM `student` WHERE ID = '$studID'";
$rs = $COMMON->executeQuery($queryForExistingUser, $_SERVER["SCRIPT_NAME"]);
if($row = mysql_fetch_row($rs)){
  
} else {
  $insert = "INSERT INTO `student`(`key`, `fName`, `lName`, `major`, `email`, `ID`) VALUES ('', '$fName', '$lName', '$major', '$email', '$studID')";
  $COMMON->executeQuery($insert, $_SERVER["SCRIPT_NAME"]);
}
?>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>Welcome</title>
</head>
<body>
  <div>
    <h2>Welcome <?php echo($fName." ".$lName); ?></h2>
  </div>
</html>
