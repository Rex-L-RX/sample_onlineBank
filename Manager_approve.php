<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve a transaction</title>
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

<p style="height: 10px"></p>
<!--approve transactions-->
<fieldset style="width: 30%; float: left; margin-left: 10%;" >
    <legend>Approve a transaction</legend>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <p>
            <label>ID:</label>
            <input type="text" name="tranId">
        </p>

        <p>
            <button type="submit" name="delete" style="width: 100px; height: 40px">Approve</button>
        </p>
    </form>
</fieldset>
<p style="height: 10px"></p>
<table>
    <tr>
        <td>ID</td>
        <td>Username</td>
        <td>Date and time</td>
        <td>Transaction type</td>
        <td>From</td>
        <td>TO</td>
        <td>Purpose</td>
        <td>Bill type</td>
        <td>Amount</td>
        <td>Approved</td>

    </tr>

</table>
<?php
include ("db_conn.php");


//query for retreiving all the items from the transfer table (order by the recent items)
    $list_query = "SELECT * FROM `transfer`  WHERE money>'25000' ORDER BY tranId DESC";
//execute the query 'list_query'
    $result= $mysqli->query($list_query);

//covert the above result into array (associative array)
//keys of the array are the column name
while($row= $result->fetch_array(MYSQLI_ASSOC)){

    //extract the values
    $id=$row['tranId'];
    $Username=$row['username'];
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

    $isApproved=$row['isApproved'];
    if($isApproved==1){
        $Approved="YES";
    }
    else{
        $Approved="NO";
    }


    //printing out with table
    ?>
    <br>
    <table>

        <tr>
            <td><?php echo $id;?></td>
            <td><?php echo $Username;?></td>
            <td><?php echo $dateTime;?></td>
            <td><?php echo $tranType;?></td>
            <td><?php echo $fromAccount;?></td>
            <td><?php echo $toAccount;?></td>
            <td><?php echo $purpose;?></td>
            <td><?php echo $billType;?></td>
            <td><?php echo $moneyType.$money;?></td>
            <td><?php echo $Approved;?></td>
        </tr>

    </table>
    <?php

}
?>



<?php
//approve a transaction
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $tranId = $_POST["tranId"];

    $query = "SELECT * FROM `transfer` WHERE `tranId`='$tranId'";
    $result = $mysqli->query($query);
    $row_transfer = $result->fetch_array(MYSQLI_ASSOC);//get transaction amount
    $toAccountNumber=$row_transfer['toAccountNumber'];
    $isApproved=$row_transfer['isApproved'];
    if($isApproved==0){

        $query = "UPDATE `transfer` SET `isApproved`=1 WHERE `tranId`='$tranId'";
        $result= $mysqli->query($query);

        $query = "SELECT * FROM `transfer` WHERE `tranId`='$tranId'";
        $result = $mysqli->query($query);
        $row_transfer = $result->fetch_array(MYSQLI_ASSOC);//get transaction amount
        $moneyType=$row_transfer['moneyType'];

        $transAccountNumber=$row_transfer['fromAccountNumber'];

        $query = "SELECT * FROM Account WHERE `accountNumber`='$transAccountNumber'";
        $result = $mysqli->query($query);
        $row_Account = $result->fetch_array(MYSQLI_ASSOC);//get balance
        $fromAccountNumber=$row_Account['accountNumber'];

        $Amount=$row_transfer['money'];
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


        $balance=$row_Account['balance']-$Amount_A;
//        echo $balance;

        $updatequery="UPDATE `Account` SET `balance`='$balance' WHERE accountNumber='$fromAccountNumber'";
        $mysqli->query($updatequery);

        //*****to Account**************///
        //get transfer type--inter or intra
        if($row_transfer['tranType']=='intra-bank_transfer'){
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

                }
            }
        }


        if ($result){
            echo '<meta http-equiv="refresh" content="0">';

        }
        else{
            echo "Delete Failed";
        }
        $mysqli->close();
    }

}


?>
<div style="height:60px;"></div>
<div class="footer">
    <p>Runxiao Liu 483386</p>
</div>


</body>
</html>

