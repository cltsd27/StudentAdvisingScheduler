<?php

include("VerifySession.php");

$verify = "staffID";
$redirect = "https://swe.umbc.edu/~michris1/CMSC331/advisingProjectPt1/public_html/staffSignIn.html";

$VERIFY = new Verify($verify, $redirect);
$VERIFY->verifySession();


?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Meeting Creator</title>
  <link rel="stylesheet" type="text/css" href="../public_html/advising.css">
</head>
<body>
  <div>
    <h2>Create Appointment</h2>
  </div>
  <div>

    <form method="post" action="adviserCreateAppt.php">

      <label for="cbIsGroup">Group</label><br>
      <input value="1" type="checkbox" name="cbIsGroup"><br>
      
      <label for="tfLocation">Location</label><br>
      <input type="text" name="tfLocation"><br>

      <label for="date">Date (yyyy-mm-dd)</label><br>
      <input type="date" name="date"><br>

      <label for="rbTime">Time slot</label><br>
      <input type="radio" name="rbTime" value="8:30">8:30 - 9:00<br>
      <input type="radio" name="rbTime" value="9:00">9:00 - 9:30<br>
      <input type="radio" name="rbTime" value="9:30">9:30 - 10:00<br>
      <input type="radio" name="rbTime" value="10:00">10:00 - 10:30<br>
      <input type="radio" name="rbTime" value="10:30">10:30 - 11:00<br>
      <input type="radio" name="rbTime" value="11:00">11:00 - 11:30<br>
      <input type="radio" name="rbTime" value="11:30">11:30 - 12:00<br>
      <input type="radio" name="rbTime" value="12:00">12:00 - 12:30<br>
      <input type="radio" name="rbTime" value="12:30">12:30 - 1:00<br>
      <input type="radio" name="rbTime" value="1:00">1:00 - 1:30<br>
      <input type="radio" name="rbTime" value="1:30">1:30 - 2:00<br>
      <input type="radio" name="rbTime" value="2:00">2:00 - 2:30<br>
      <input type="radio" name="rbTime" value="2:30">2:30 - 3:00<br>
      <input type="radio" name="rbTime" value="3:00">3:00 - 3:30<br>
      <input type="radio" name="rbTime" value="3:30">3:30 - 4:00<br>
      <input type="radio" name="rbTime" value="4:00">4:00 - 4:30<br>
      <input type="radio" name="rbTime" value="4:30">4:30 - 5:00<br>

      <input type="submit" value="Submit">

    </form>
    
  </div>
  <a href="../public_html/adviserHome.html"> Home </a>
</body>
</html>
