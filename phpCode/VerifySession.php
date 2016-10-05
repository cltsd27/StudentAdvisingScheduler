<?php 


  /*
  ** This class acts as a way to verify the session. Students
  ** should only be able to view webpages that are meant for students
  ** and not advisors and vice versa.
  **
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

  //If the current session is invalid, redirect
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