
<?php
/*
File:	 adviserViewAppt.php
Project: CMSC 331 Project 1
Author:	 Elizabeth Aucott 
Date:	 10/8/16  Edited 10/13/16 by Elizabeth

         This is the adviser view appointment php page. 
         The date input box only works with Chrome or Opera. 
*/

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
        <div class="title"> <h2>View Appointments</h2> </div>

        <div class="content">
          <form method="post" action="../phpCode/adviserViewAppt.php">
            <!-- This date form only works in Opera and Chrome.
                 Apparently to get a little calendar you need to use
                 Javascript. I guess that will be something we can implement in
                 project 2. -->
            <label for="datePickedDay">Select a date (yyyy-mm-dd):</label><br>
            <input type="date" name="datePickedDay"><br><br>
            
			<input type="submit" value="Submit"><br>
          </form> 
          
          <br>
          <a href="../public_html/adviserHome.html"> Home </a>
        </div>
      </div> 
    </div>
  </body>
</html>
