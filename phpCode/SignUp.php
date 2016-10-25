<?php


/*

File:    SignUp.php
Project: CMSC 331 Project 1
Author:  Christopher Mills
Date:    10/8/16
        
         This class is responsible for signing a user in
	 and creating a row in the table if the user does
	 not exist. 

*/
class SignUp 
{

  var $fields;
  var $ID;
  var $table;
  var $postData;
  var $escapedID;
  var $COMMON;

  
  /* constructor 
  ** $fields:   array that contains the keys of the posted data
  ** $postData: the posted data
  ** $ID:       either staffID or studentID
  ** $table:    the name of the table that is used for logging in
  */
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
  
  /* signIn
  ** Precondition: none
  ** Postcondition: the user is either signed up and logged in, or just logged in
  ** NOTE: this is the only function that other php pages should call!
  */
  function signIn() {
    
    
    if(!$this->isUserPresent()) {
      $insert = $this->buildInsertQuery();
      $this->COMMON->executeQuery($insert, $_SERVER["SCRIPT_NAME"]);
    }
    $this->setSessionVariables();
  }

  /* getEscapedData
  ** Precondition: postData and fields are set
  ** Postcondition: an array is returned that has all the elements of postData
  **                escaped using mysql_real_escape_string
  */
  function getEscapedData(){
    
    $escapedData;
    foreach($this->fields as $field) {
      
      $escapedData[$field] = mysql_real_escape_string($this->postData[$field]);

    }
    return $escapedData;

  }


  /* isUserPresent
  ** Precondition: $this->table exists in the database
  ** Postcondition: a boolean is returned indicating whether the user exists already
  */
  function isUserPresent() {


    $queryExistingUser = $this->buildSearchQuery();
    $rs = $this->COMMON->executeQuery($queryExistingUser, $_SERVER["SCRIPT_NAME"]);
    if($row = mysql_fetch_row($rs)){
      return true;
    } else {
      return false;
    }
  }

  /* buildSearchQuery
  ** Precondition: $this->table exists in the database
  ** Postcondition: an SQL query that checks for an ID is returned
  */
  function buildSearchQuery() {
    return "SELECT * FROM `$this->table` WHERE `ID` = '$this->escapedID'";
  }

  /* buildInsertQuery
  ** Precondition: $this->table exists in the database
  ** Postcondition: a query that inserts a user based on the $this->postData is returned
  */
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

  /* setSessionVariables
  ** Precondition: the user has been created already
  ** Postcondition: php session variables are set based on the users information
  **                effectively logging the user in
  */
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



}

?>