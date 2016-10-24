<?php

include("VerifySession.php");

$verify = "staffID";
$redirect = "../public_html/staffSignIn.html";

$VERIFY = new Verify($verify, $redirect);
$VERIFY->verifySession();


?>

<!DOCTYPE html>
<html>
  <head>
    <title>UMBC Advising</title>
    <link rel="stylesheet" type="text/css" href="../public_html/advising.css">
  </head>
  
  <body>
    <div class="background"> 
      <div class="paw">
        <div class="title"> <h2>Create Appointment</h2> </div>

        <div class="content">
          <form method="post" action="adviserCreateAppt.php">
          
          <label for="cbIsGroup">Group</label><br>
          <input value="1" type="checkbox" name="cbIsGroup"><br>
      
          <label for="tfLocation">Location</label><br>
          <input type="text" name="tfLocation"><br>

          <label for="date">Date (yyyy-mm-dd)</label><br>
          <input type="date" name="date"><br>
          
          <label for="Time">Time slot:</label><br>
            <select name="Time">
			  <option value="8:30">8:30 - 9:00</option>
              <option value="9:00">9:00 - 9:30</option>
              <option value="9:30">9:30 - 10:00</option>
              <option value="10:00">10:00 - 10:30</option>
              <option value="10:30">10:30 - 11:00</option>
              <option value="11:00">11:00 - 11:30</option>
              <option value="11:30">11:30 - 12:00</option>
              <option value="12:00">12:00 - 12:30</option>
              <option value="12:30">12:30 - 1:00</option>
              <option value="13:00">1:00 - 1:30</option>
              <option value="13:30">1:30 - 2:00</option>
              <option value="14:00">2:00 - 2:30</option>
              <option value="14:30">2:30 - 3:00</option>
              <option value="15:00">3:00 - 3:30</option>
              <option value="15:30">3:30 - 4:00</option>
              <option value="16:00">4:00 - 4:30</option>
              <option value="16:30">4:30 - 5:00</option>
            </select><br><br>
            
            <input type="submit" value="Submit"><br>
            
            <p><br></p>
            <a href="../public_html/adviserHome.html"> Home </a>

          </form>
        </div>
      </div> 
    </div>
  </body>
</html>

