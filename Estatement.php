<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Estatement</title>
    <link rel="stylesheet" type="text/css" href="css/Account.css">
    <link rel="stylesheet" type="text/css" href="css/table.css">
    <!--    forbid to go on previous page-->
    <script type="text/javascript">
        history.go(1);
    </script>
</head>
<body>
<div id="div1">
    <div id="Logo">
        <img src="picture/logo.jpg"><!--img logo-->
    </div>
    <div id="transaction_section">
        <ul>
            <li><a href="Account.php">Account</a></li>
            <li><a href="Transaction.php">Transaction</a></li>
            <li><a href="Transfer.php">Transfer & Pay</a></li>
            <li><a href="Estatement.php">Estatement</a></li>
            <li style="float:right"><a class="active" href="Logout_process.php">Sign out</a></li>
        </ul>


    </div>



</div>
<div style=" border-width: 3px; border-color: blanchedalmond;">
    <!--         show username and account type on account page-->
    <div style="height: 50%;

             position: relative;
             left: 200px;
             top: 20px;
             margin-bottom: 10px;
             font-size: 16px"
         id="account_detail">
        <?php
        include("session.php");
        include ("Validate_access_Permission.php");

        //show username
        echo "<br>";
        echo "Hello, "."$session_username"."<br>";
        //show last access time
        echo "Your last log in time is:"."$last_login_date_time";
        ?>

    </div>
</div>
<p style="height: 10px"></p>
<fieldset>
    <legend>Estatement</legend>
    <p>The fee will be deducted from your Saving account.(Your account balance need to be more than $7)</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
    <input type="radio" name="estatement" value="one_m">One month($2.5)
    <input type="radio" name="estatement" value="three_m">Three month($5)
    <input type="radio" name="estatement" value="six_m">Six month(7$)<br>
        <button type="submit" name="submit">Submit</button>
    </form>
</fieldset>
<p style="height: 10px"></p>

<table>
    <tr>
        <td>ID</td>
        <td>Date and time</td>
        <td>Transaction type</td>
        <td>From</td>
        <td>TO</td>
        <td>Purpose</td>
        <td>Bill type</td>
        <td>Amount</td>
    </tr>

</table>
<?php
include ("db_conn.php");
$estatement=$_POST['estatement'];
$query = "SELECT * FROM Account WHERE username ='$session_username'AND `accountType`='Saving'";
$result = $mysqli->query($query);
$row = $result->fetch_array(MYSQLI_ASSOC);
$accountNumber=$row['accountNumber'];
$transTime=date("Y-m-d H:i:s"); //get transfer time


if ($row['balance']>7){
    if ($estatement=='one_m'){//a month
        //select 1 month
        $list_query = "SELECT * FROM `transfer` WHERE (DATE_FORMAT( createTime, '%Y%m' ) =DATE_FORMAT( CURDATE( ) , '%Y%m' )AND `isApproved`='1') and username='$session_username' ORDER BY tranId DESC";
        //execute the query 'list_query'
        $result= $mysqli->query($list_query);
        //update balance
        $balance=$row['balance']-2.5;
        $updatequery="UPDATE `Account` SET `balance`='$balance' WHERE `username`='$session_username'AND `accountType`='Saving'";
        $mysqli->query($updatequery);

        //insert into table transfer
        $query="INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `createTime`,`isApproved`) VALUES ('$session_username','Statement','2.5','AUD','017324','$accountNumber','$transTime','1')";
        $mysqli->query($query);

    }
    elseif ($estatement=='three_m'){//3 months
        //select 3 month
        $list_query = "SELECT * FROM transfer where (DATE_SUB(CURDATE(), INTERVAL 90 DAY) <= date(createTime) AND `isApproved`='1') and username='$session_username' ORDER BY tranId DESC";
        //execute the query 'list_query'
        $result= $mysqli->query($list_query);
        //update balance
        $balance=$row['balance']-5;
        $updatequery="UPDATE `Account` SET `balance`='$balance' WHERE `username`='$session_username'AND `accountType`='Saving'";
        $mysqli->query($updatequery);

        //insert into table transfer
        $query="INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `createTime`,`isApproved`) VALUES ('$session_username','Statement','5','AUD','017324','$accountNumber','$transTime','1')";
        $mysqli->query($query);
    }
    elseif ($estatement=='six_m'){//6 months
        //select 6 month
        $list_query = "SELECT * FROM transfer where (DATE_SUB(CURDATE(), INTERVAL 180 DAY) <= date(createTime) AND `isApproved`='1') and username='$session_username' ORDER BY tranId DESC";
        //execute the query 'list_query'
        $result= $mysqli->query($list_query);
        //update balance
        $balance=$row['balance']-7;
        $updatequery="UPDATE `Account` SET `balance`='$balance' WHERE `username`='$session_username'AND `accountType`='Saving'";
        $mysqli->query($updatequery);

        //insert into table transfer
        $query="INSERT INTO `transfer`(`username`, `tranType`, `money`, `moneyType`, `fromBSB`, `fromAccountNumber`, `createTime`,`isApproved`) VALUES ('$session_username','Statement','7','AUD','017324','$accountNumber','$transTime','1')";
        $mysqli->query($query);
    }
}
else{
    $message = "You do not have enough balance!"; //alert
    echo "<script type='text/javascript'>alert('$message');</script>";
}


//covert the above result into array (associative array)
//keys of the array are the column name
while($row= $result->fetch_array(MYSQLI_ASSOC)){

    //extract the values
    $id=$row['tranId'];
    $dateTime=$row['createTime'];
    $tranType=$row['tranType'];
    $fromAccount=$row['fromAccountNumber'];

    $toBSB=$row['toBSB'];
    $toAccountNumber=$row['toAccountNumber'];

    $toAccount=$toAccountNumber."-".$toBSB;

    $purpose=$row['transferPurpose'];
    $billType=$row['billType'];

    $money=$row['money'];
    $moneyType=$row['moneyType'];


    //printing out with table
    ?>
    <br>
    <table>
        <tr>
            <td><?php echo $id;?></td>
            <td><?php echo $dateTime;?></td>
            <td><?php echo $tranType;?></td>
            <td><?php echo $fromAccount;?></td>
            <td><?php echo $toAccount;?></td>
            <td><?php echo $purpose;?></td>
            <td><?php echo $billType;?></td>
            <td><?php echo $moneyType.$money;?></td>
        </tr>

    </table>
    <?php

}
?>
<div style="height:60px;"></div>
<div class="footer">
    <p>Runxiao Liu 483386</p>
</div>





</body>
</html>
