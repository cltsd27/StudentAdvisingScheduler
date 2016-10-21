<?php

include("SignUp.php");
$fields = ["FirstName", "LastName", "Department", "Email"];
$ID = "staffID";
$table = "Adviser";


$SIGNUP = new SignUp($fields, $_POST, $ID, $table);
$SIGNUP->signIn();
$fName = $_POST["fName"];
$lName = $_POST["lName"];
$homePage = "../public_html/adviserHome.html";

header("Location: $homePage");
?>
