<?php
//starting session
session_start();

//if the session for username has not been set, initialise it
if(!isset($_SESSION['accountType'])){
    $_SESSION['accountType']="normal";
}
if(!isset($_SESSION['access'])){
    $_SESSION['access']=0;
}
//save account type
$session_accountType=$_SESSION['accountType'];

$session_access=$_SESSION['access'];
//save username in the session
$session_username=$_SESSION['username'];

//last login date and time
$last_login_date_time=$_SESSION['last_login_date_time'];



//login time&date
$session_login_date_time=$_SESSION['login_date_time'];


//logout time&date
$session_logout_date_time=$_SESSION['logout_date_time'];

//account number business
$accountNumber_B=$_SESSION['$accountNumber_B'];
$accountBalance_B=$_SESSION['$accountBalance_B'];



//account number saving
$accountNumber_S=$_SESSION['$accountNumber_S'];
$accountBalance_S=$_SESSION['$accountBalance_S'];


?>