<?php
include ("db_conn.php");
include ("session.php");
//Get logout time

//update login time
$session_login_date_time=$_SESSION['login_date_time'];
//                 echo "$session_login_date_time";
$updatequery="UPDATE `users` SET `lastLoginTime`='$session_login_date_time' WHERE username='$session_username'" ;
$mysqli->query($updatequery);
//reset session access
$_SESSION['access'] = 0;
$logout_date_time=date("Y-m-d H:i:s");
$updatequery="UPDATE `users` SET LastLogoutTime='$logout_date_time' WHERE username='$session_username'" ;
$mysqli->query($updatequery);



//go back to index page
header('location: ./index.html');
?>



