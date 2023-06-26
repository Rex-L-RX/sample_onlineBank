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
    <script
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    <script src="jquery.validate.js"></script>
</head>
<body>
<div id="div1">
    <div id="Logo">
        <img src="picture/logo.jpg"><!--img logo-->
    </div>
    <div id="transaction_section">
        <ul>
            <li><a href="Manager_account.php">Account</a></li>
            <li><a href="Manager_add_account.php">Add an account</a></li>
            <li><a href="Manager_users.php">Users</a></li>
            <li><a href="Manager_transaction.php">Transaction</a></li>
            <li><a href="Manager_approve.php">Approve</a></li>
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
        include ("Validate_access_permission_M.php");

        //show username
        echo "<br>";
        echo "Hello, "."$session_username"."<br>";
        //show last access time
        echo "Your last log in time is:"."$session_login_date_time";

        ?>

    </div>
</div>
<fieldset style="width: 30%;float: left; margin-left: 10%; margin-top: 15px;">
    <legend>Transaction history</legend>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <input type="radio" name="transHistory" value="all">All
        <input type="radio" name="transHistory" value="one_d">A day
        <input type="radio" name="transHistory" value="seven_d">last 7 days
        <input type="radio" name="transHistory" value="one_m">A month
        <input type="radio" name="transHistory" value="three_m">Last three months<br>
        <button type="submit" name="submit">Submit</button>
    </form>
</fieldset>


<table style="margin-top: 7%;">
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
$transHistory=$_POST['transHistory'];
$query = "SELECT * FROM Account WHERE username ='$session_username'AND `accountType`='Saving'";
$result = $mysqli->query($query);
$row = $result->fetch_array(MYSQLI_ASSOC);
$accountNumber=$row['accountNumber'];
$transTime=date("Y-m-d H:i:s"); //get transfer time

    if ($transHistory=='all'){
        //select all
        $list_query = "SELECT * FROM `transfer` ORDER BY tranId DESC";
        //execute the query 'list_query'
        $result= $mysqli->query($list_query);

    }
    elseif ($transHistory=='one_d'){//1 day
        //select a day
        $list_query = "select * from transfer where to_days(createTime) = to_days(now()) AND `isApproved`='1' ORDER BY tranId DESC";
        //execute the query 'list_query'
        $result= $mysqli->query($list_query);

    }
    elseif ($transHistory=='seven_d'){//7 days
        //select a week
        $list_query = " SELECT * FROM transfer where DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(createTime) AND `isApproved`='1' ORDER BY tranId DESC";
        //execute the query 'list_query'
        $result= $mysqli->query($list_query);

    }
    elseif ($transHistory=='one_m'){
        //select 1 month
        $list_query = "SELECT * FROM `transfer` WHERE DATE_FORMAT( createTime, '%Y%m' ) =DATE_FORMAT( CURDATE( ) , '%Y%m' )AND `isApproved`='1' ORDER BY tranId DESC";
        //execute the query 'list_query'
        $result= $mysqli->query($list_query);
    }
    elseif ($transHistory=='three_m'){
        //select 3 month
        $list_query = "SELECT * FROM transfer where DATE_SUB(CURDATE(), INTERVAL 90 DAY) <= date(createTime) AND `isApproved`='1' ORDER BY tranId DESC";
        //execute the query 'list_query'
        $result= $mysqli->query($list_query);
    }
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

