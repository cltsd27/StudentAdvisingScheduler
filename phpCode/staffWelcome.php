<?php

include("SignUp.php");
$fields = ["fName", "lName", "department", "email"];
$ID = "staffID";
$table = "staff";


$SIGNUP = new SignUp($fields, $_POST, $ID, $table);
$SIGNUP->signIn();
$fName = $_POST["fName"];
$lName = $_POST["lName"];

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
