<?php
//pay bill
include ("db_conn.php");
include ("session.php");

$accountType=$_POST["accountType"];//get account type
$toBSB=$_POST["BSB"];//get BSB number
$toAccountNumber=$_POST["accountNumber"]; //get to account number
$Amount=$_POST["Amount"];   //get to amount
$billType=$_POST["billType"]; //get bill type

$transTime=date("Y-m-d H:i:s"); //get transfer time

$transType="Bill_payments";
$moneyType="AUD";

$_SESSION['accountType1']=$accountType;
$_SESSION['toBSB1']=$toBSB;
$_SESSION['toAccountNumber1']=$toAccountNumber;
$_SESSION['Amount1']=$Amount;
$_SESSION['billType1']=$billType;

//get from account number
if($accountType=='Business'){
    $fromAccountNumber="$accountNumber_B";

}
else if ($accountType=='Saving'){
    $fromAccountNumber="$accountNumber_S";
}
$_SESSION['fromAccountNumber1']=$fromAccountNumber;


    //get daily transfer sum from database.
    $query = "SELECT * FROM transfer WHERE  fromAccountNumber ='$fromAccountNumber' AND to_days(createTime) = to_days(now());";
    $result = $mysqli->query($query);

    $sum=$Amount;

    while($row= $result->fetch_array(MYSQLI_ASSOC)){

        //extract the values
        $amount=$row['money'];

        $sum=$amount+$sum;
    }
    //if business sum>50000, cancel it.
    if ($accountType=='Business'&&$sum>50000){

        $message = "Business account transfer limitation is $50000/day"; //alert
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "Transfer.php?"; //go back
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
    //if saving sum>10000,cancel it.
    elseif ($accountType=='Saving' &&$sum>10000){

        $message = "Saving account transfer limitation is $10000/day"; //alert
        echo "<script type='text/javascript'>alert('$message');</script>";
        $url = "Transfer.php?"; //go back
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }
    else{
        //if amount>25000, it need to be approved by manager
        if($Amount>25000){
            $query = "SELECT * FROM Account WHERE username ='$session_username'AND `accountType`='$accountType'";
            $result = $mysqli->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $balance=$row['balance']-$Amount;
            //validate balance
            if($balance>0){
                $query="INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `toBSB`, `toAccountNumber`, `billType`, `createTime`,`isApproved`) VALUES ('$session_username','$transType','$Amount','$moneyType','017324','$fromAccountNumber','$toBSB','$toAccountNumber','$billType','$transTime','0')";
                $mysqli->query($query);


                $_SESSION['purpose1']=null;

                //go to after transfer&pay page
                $url = "Aftertransfer_pay.php";
                echo "<script type='text/javascript'>";
                echo "window.location.href='$url'";
                echo "</script>";


            }
            else{
                $message = "You do not have enough balance on your account"; //alert
                echo "<script type='text/javascript'>alert('$message');</script>";
                $url = "Transfer.php?"; //go back
                echo "<script type='text/javascript'>";
                echo "window.location.href='$url'";
                echo "</script>";
            }

        }
        else{
            $query = "SELECT * FROM Account WHERE username ='$session_username'AND `accountType`='$accountType'";
            $result = $mysqli->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $balance=$row['balance']-$Amount;
            //validate balance
            if($balance>0) {
                $query = "INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `toBSB`, `toAccountNumber`, `billType`, `createTime`,`isApproved`) VALUES ('$session_username','$transType','$Amount','$moneyType','017324','$fromAccountNumber','$toBSB','$toAccountNumber','$billType','$transTime', '1')";
                $mysqli->query($query);

                //update balance in database-Account
                $updatequery="UPDATE `Account` SET `balance`='$balance' WHERE `username`='$session_username'AND `accountType`='$accountType'";
                $mysqli->query($updatequery);
                $_SESSION['purpose1']=null;

                //go to after transfer&pay page
                $url = "Aftertransfer_pay.php";
                echo "<script type='text/javascript'>";
                echo "window.location.href='$url'";
                echo "</script>";
            }
            else{
                $message = "You do not have enough balance on your account"; //alert
                echo "<script type='text/javascript'>alert('$message');</script>";
                $url = "Transfer.php?"; //go back
                echo "<script type='text/javascript'>";
                echo "window.location.href='$url'";
                echo "</script>";
            }
        }

    }









?>