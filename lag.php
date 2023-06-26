<?php
include "db_conn.php";
include "session.php";





    //set credit card as 1;
    $updatequery = "UPDATE `Account` SET creditCard='1' WHERE `username`='$session_username'";
    $mysqli->query($updatequery);
    //update balance
    $query = "SELECT * FROM Account WHERE username ='$session_username' AND accountType='Saving'";
    $result = $mysqli->query($query);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $balance=$row['balance'];
    $balance=$balance-50;
    $updatequery = "UPDATE `Account` SET balance='$balance' WHERE `username`='$session_username' AND accountType='Saving'";
    $mysqli->query($updatequery);



//go back to account page
header('location: ./Account.php');