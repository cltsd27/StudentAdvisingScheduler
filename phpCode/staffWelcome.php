<?php

include('./CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

$fName = mysql_real_escape_string($_POST["fName"]);
$lName = mysql_real_escape_string($_POST["lName"]);
$staffID = mysql_real_escape_string(strtolower($_POST["staffID"]));
$email = mysql_real_escape_string($_POST["email"]);
$department = mysql_real_escape_string($_POST["department"]);


$queryForExistingUser = "SELECT * FROM `staff` WHERE ID = '$staffID'";
$rs = $COMMON->executeQuery($queryForExistingUser, $_SERVER["SCRIPT_NAME"]);
if($row = mysql_fetch_row($rs)){
  
} else {
  $insert = "INSERT INTO `staff`(`key`, `fName`, `lName`, `department`, `email`, `ID`) VALUES ('', '$fName', '$lName', '$department', '$email', '$staffID')";
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
