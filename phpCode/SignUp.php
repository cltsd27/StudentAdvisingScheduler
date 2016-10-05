<?php


  /*
  ** This class is responsible for signing a user in
  ** and creating a row in the table if the user does
  ** not exist. 
  **
  */
class SignUp 
{

  var $fields;
  var $ID;
  var $table;
  var $postData;
  var $escapedID;
  var $COMMON;

  

  function SignUp($fields, $postData, $ID, $table) {
  
    include('CommonMethods.php');  
    $this->fields = $fields;
    $this->ID = $ID;                //this is the name of the column (staffID, studentID)
    $this->table = $table;
    $this->postData = $postData;
    $debug = false;
    $this->COMMON = new Common($debug);
    //escape the ID from post data and set it
    $this->escapedID = mysql_real_escape_string($this->postData[$this->ID]);

  }

  function getEscapedData(){
    
    $escapedData;
    //escape all the data fields and return the array of data
    foreach($this->fields as $field) {
      
      $escapedData[$field] = mysql_real_escape_string($this->postData[$field]);

    }
    return $escapedData;

  }


  //return true if the user is present in the database, otherwise false
  function isUserPresent() {


    $queryExistingUser = $this->buildSearchQuery();
    $rs = $this->COMMON->executeQuery($queryExistingUser, $_SERVER["SCRIPT_NAME"]);
    if($row = mysql_fetch_row($rs)){
      return true;
    } else {
      return false;
    }
  }

  function buildSearchQuery() {
    return "SELECT * FROM `$this->table` WHERE ID = '$this->escapedID'";
  }

  //insert the user into the table by using the data from $fields
  function buildInsertQuery() {

    $escapedData = $this->getEscapedData();
    $insert = "INSERT INTO `$this->table`(`key`, ";
    foreach($this->fields as $field) {
      $insert = $insert . "`$field`, ";
    }
    $insert = $insert . "`ID`) VALUES ('', ";
    foreach($escapedData as $data){
      $insert = $insert . "'$data', ";
    }
    $insert = $insert . "'$this->escapedID')";
    return $insert;
  }

  function setSessionVariables() {

    session_start();
    $queryForUser = $this->buildSearchQuery();
    $rs = $this->COMMON->executeQuery($queryForUser, $_SERVER["SCRIPT_NAME"]);
    $row = mysql_fetch_row($rs);
    $_SESSION["key"] = $row[0];
    $_SESSION[$this->ID] = $this->escapedID;
    $escapedData = $this->getEscapedData();
    foreach($this->fields as $field){
      $_SESSION[$field] = $escapedData[$field];
    }
  }

  //This should be the only function called by other php pages
  function signIn() {
    
    
    if(!$this->isUserPresent()) {
      $insert = $this->buildInsertQuery();
      $this->COMMON->executeQuery($insert, $_SERVER["SCRIPT_NAME"]);
    }
    $this->setSessionVariables();
  }

}

?>