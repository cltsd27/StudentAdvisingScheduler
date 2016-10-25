<?php 


/*
File:    VerifySession.php
Project: CMSC 331 Project 1
Author:  Christopher Mills
Date:    10/8/16
         
         This class acts as a way to verify the session. Students
	 should only be able to view webpages that are meant for students
	 and not advisors and vice versa.
	 NOTE: Verify a session before any other php code is run!!

*/
class Verify
{

  var $sessionVar;
  var $redirect;

  //This class requires the sesion variable to be checked
  //and the location to redirect if needed
  function Verify($sessionVar, $redirect)
  {

    $this->sessionVar = $sessionVar;
    $this->redirect = $redirect;
    
  }

  /* verifySession
  ** Precondition: none
  ** Postcondition: the user is redirected to a log in page if they are not logged in
  */
  function verifySession() {

    session_start();
    if(!isset($_SESSION[$this->sessionVar])){
      echo($this->redirect);
      header("Location: $this->redirect");
      exit();
    }
  }

}


?>