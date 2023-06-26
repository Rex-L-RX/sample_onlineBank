<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction</title>
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
        include "db_conn.php";
        //show username
        echo "<br>";
        echo "Hello, "."$session_username"."<br>";
        //show last access time
        echo "Your last log in time is:"."$last_login_date_time";

        $query = "SELECT * FROM Account WHERE username ='$session_username'AND `accountType`='Business'";
        $result = $mysqli->query($query);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $accountNumber0=$row['accountNumber'];
        $accountNumber1=$accountNumber0+1;
        ?>

    </div>

</div>

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
//query for retreiving all the items from the transfer table (order by the recent items)
$list_query = "SELECT * FROM `transfer`  WHERE (username='$session_username' OR toAccountNumber='$accountNumber0' OR toAccountNumber='$accountNumber1')AND `isApproved`='1' ORDER BY tranId DESC";
//execute the query 'list_query'
$result= $mysqli->query($list_query);

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

    $toAccount=$toBSB."-".$toAccountNumber;

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
