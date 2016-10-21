<?php

include("SignUp.php");
$fields = ["FirstName", "LastName", "Email", "Major"];
$ID = "studID";
$table = "Student";


$SIGNUP = new SignUp($fields, $_POST, $ID, $table);
$SIGNUP->signIn();
$fName = $_POST["fName"];
$lName = $_POST["lName"];
$homePage = "../public_html/studentHome.html";

header("Location: $homePage");
?>
