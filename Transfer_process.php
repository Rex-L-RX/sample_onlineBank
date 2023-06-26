<?php
//transfer
include ("db_conn.php");
include ("session.php");

$accountType=$_POST["accountType"];//get account type
$toBSB=$_POST["BSB"];//get BSB number
$toAccountNumber=$_POST["accountNumber"]; //get to account number
$Amount=$_POST["Amount"];   //get to amount
$moneyType=$_POST["moneyType"]; //get currency type
$purpose=$_POST["purpose"];// get transfer purpose
$transTime=date("Y-m-d H:i:s"); //get transfer time

//Exchange rate calculation
switch ($moneyType){
    case "AUD":
        $Amount_A=$Amount;
        break;
    case "USD":
        $Amount_A=$Amount*1.45;
        break;
    case "GBP":
        $Amount_A=$Amount*1.84;
}



$_SESSION['accountType1']=$accountType;
$_SESSION['toBSB1']=$toBSB;
$_SESSION['toAccountNumber1']=$toAccountNumber;
$_SESSION['Amount1']=$Amount;
$_SESSION['purpose1']=$purpose;
$_SESSION['moneyType']=$moneyType;




    if($toBSB=='017324'){
        $transType="intra-bank_transfer";
    }
    else{
        $transType="inter-bank_transfer";
    }
    //get from account number
    if($accountType=='Business'){
        $fromAccountNumber="$accountNumber_B";

    }
    else if ($accountType=='Saving'){
        $fromAccountNumber="$accountNumber_S";
    }

    $_SESSION['fromAccountNumber1']=$fromAccountNumber;
//insert variables into database-transfer



        $query = "SELECT * FROM transfer WHERE  fromAccountNumber ='$fromAccountNumber' AND to_days(createTime) = to_days(now());";
        $result = $mysqli->query($query);

        $sum=$Amount_A;
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
        if($Amount_A>25000){
            $query = "SELECT * FROM Account WHERE username ='$session_username'AND `accountType`='$accountType'";
            $result = $mysqli->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $balance=$row['balance']-$Amount_A;
            if($balance>0){
                $query="INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `toBSB`, `toAccountNumber`, `transferPurpose`, `createTime`,`isApproved`) VALUES ('$session_username','$transType','$Amount','$moneyType','017324','$fromAccountNumber','$toBSB','$toAccountNumber','$purpose','$transTime','0')";
                $mysqli->query($query);

                $_SESSION['billType1']=null; //get bill type

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
                if($accountType=='Saving' && $moneyType=='AUD'){
                    //validate balance
                    // get current balance from database-Account
                    $query = "SELECT * FROM Account WHERE username ='$session_username'AND `accountType`='$accountType'";
                    $result = $mysqli->query($query);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $balance=$row['balance']-$Amount_A;


                    if($balance>0){

                        //validate the bsb number to know it is inter or intra transfer.
                        if ($toBSB=='017324'){
                            //get toAccount balance
                            $query = "SELECT * FROM `Account` WHERE accountNumber='$toAccountNumber' ";
                            $result = $mysqli->query($query);
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            $toBalance=$row['balance'];
                            $toBalance=$toBalance+$Amount_A;


                            if(mysqli_num_rows($result) > 0){
                                //update toAccount balance
                                $updatequery="UPDATE `Account` SET `balance`='$toBalance' WHERE accountNumber='$toAccountNumber' ";
                                $mysqli->query($updatequery);
                            }




                        }
                        $query="INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `toBSB`, `toAccountNumber`, `transferPurpose`, `createTime`,`isApproved`) VALUES ('$session_username','$transType','$Amount','$moneyType','017324','$fromAccountNumber','$toBSB','$toAccountNumber','$purpose','$transTime','1')";
                        $mysqli->query($query);

                        //update balance in database-Account
                        $updatequery="UPDATE `Account` SET `balance`='$balance' WHERE `username`='$session_username'AND `accountType`='$accountType'";
                        $mysqli->query($updatequery);
                        $_SESSION['billType1']=null; //get bill type

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
                else if ($accountType=='Business'){
                    //validate balance
                    // get current balance from database-Account
                    $query = "SELECT * FROM Account WHERE username ='$session_username'AND `accountType`='$accountType'";
                    $result = $mysqli->query($query);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $balance=$row['balance']-$Amount_A;
                    if($balance>0){

                        //validate weather the bsb number.
                        if ($toBSB=='017324'){
                            //get toAccount balance
                            $query = "SELECT * FROM `Account` WHERE accountNumber='$toAccountNumber' ";
                            $result = $mysqli->query($query);
                            $row = $result->fetch_array(MYSQLI_ASSOC);

                            //validate account type
                            if($row['accountType']=='Saving' && $moneyType!='AUD'){
                                $message = "Saving account only can receive AUD!"; //alert
                                echo "<script type='text/javascript'>alert('$message');</script>";
                                $url = "Transfer.php?"; //go back
                                echo "<script type='text/javascript'>";
                                echo "window.location.href='$url'";
                                echo "</script>";

                            }
                            else{
                                $toBalance=$row['balance'];
                                $toBalance=$toBalance+$Amount_A;

                                    if(mysqli_num_rows($result) > 0){
                                        //update toAccount balance
                                        $updatequery="UPDATE `Account` SET `balance`='$toBalance' WHERE accountNumber='$toAccountNumber' ";
                                        $mysqli->query($updatequery);

                                        $query="INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `toBSB`, `toAccountNumber`, `transferPurpose`, `createTime`,`isApproved`) VALUES ('$session_username','$transType','$Amount','$moneyType','017324','$fromAccountNumber','$toBSB','$toAccountNumber','$purpose','$transTime','1')";
                                        $mysqli->query($query);
                                        //update balance in database-Account
                                        $updatequery="UPDATE `Account` SET `balance`='$balance' WHERE `username`='$session_username'AND `accountType`='$accountType'";
                                        $mysqli->query($updatequery);
                                        $_SESSION['billType1']=null; //get bill type

                                        //go to after transfer&pay page
                                        $url = "Aftertransfer_pay.php";
                                        echo "<script type='text/javascript'>";
                                        echo "window.location.href='$url'";
                                        echo "</script>";
                                    }
                                }
                            }
                        else{
                            $query="INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `toBSB`, `toAccountNumber`, `transferPurpose`, `createTime`,`isApproved`) VALUES ('$session_username','$transType','$Amount','$moneyType','017324','$fromAccountNumber','$toBSB','$toAccountNumber','$purpose','$transTime','1')";
                            $mysqli->query($query);
                            //update balance in database-Account
                            $updatequery="UPDATE `Account` SET `balance`='$balance' WHERE `username`='$session_username'AND `accountType`='$accountType'";
                            $mysqli->query($updatequery);
                            $_SESSION['billType1']=null; //get bill type

                            //go to after transfer&pay page
                            $url = "Aftertransfer_pay.php";
                            echo "<script type='text/javascript'>";
                            echo "window.location.href='$url'";
                            echo "</script>";
                        }


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
                    $message = "Saving account is AUD only!"; //alert
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    $url = "Transfer.php?"; //go back
                    echo "<script type='text/javascript'>";
                    echo "window.location.href='$url'";
                    echo "</script>";
                }

        }
}






?>




