<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transfer&Pay</title>
    <link rel="stylesheet" type="text/css" href="css/Account.css">
    <!--    forbid to go on previous page-->
    <script type="text/javascript">
        history.go(1);
    </script>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    <script src="jquery.validate.js"></script>
    <script>

        function validate(){                // validate sign up
            if($("#BSB").val() == ""){
                alert("please enter your transfer account BSB.");
                return false;
            }

            else if ($("#accountNumber").val()==""){
                alert("please enter your transfer account number.");
                return false;
            }
            else if($("#Amount").val()==""){
                alert("Please enter your transfer amount.");
                return false;
            }

            else if($("#purpose").val()==""){
                    alert("Please enter your transfer purpose.");
                    return false;
                }


        }


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

        $accountNumber_B=$_SESSION['$accountNumber_B'];
        $accountBalance_B=$_SESSION['$accountBalance_B'];

        $accountNumber_S=$_SESSION['$accountNumber_S'];
        $accountBalance_S=$_SESSION['$accountBalance_S'];


        ?>
    </div>
</div>
<div id="div2">
    <div class="account_section">
        <p style="font-size: 34px;" >Business Account</p>
        <div class="account_detail">
            <p style="font-size: 30px;">Account Details</p>
            <p>BSB: 017324</p>          <!--account details-->
            <p>Client Number: <?php echo $accountNumber_B; ?></p>
        </div>
        <div class="account_balance">
            <p style="font-size: 30px;">Balance</p>
            <p>AU$<?php echo $accountBalance_B; ?></p>
        </div>
    </div>

    <div class="account_section">
        <p style="font-size: 34px;">Saving Account</p>
        <div class="account_detail">
            <p style="font-size: 30px;">Account Details</p>
            <p>BSB: 017324</p>          <!--account details-->
            <p>Client Number: <?php echo $accountNumber_S; ?></p>
        </div>
        <div class="account_balance">
            <p style="font-size: 30px;">Balance</p>
            <p>AU$<?php echo $accountBalance_S; ?></p>
        </div>
    </div>
</div>
<div style="background-color: azure;width: 35%; float:left; margin-left: 100px;">

<p style="font-size: 25px">Transfer</p>
<p style="color: red">Business Account's transactions up to $50000/day. </p>
<p style="color: red">Saving Account's transactions up to $10000/day. </p>
<p style="color: red">Transactions over $25000 need to be approved by manager</p>

<form action="Transfer_process.php" method="post" onsubmit="return validate();">
    <input type="radio" value="Business" checked="checked" name="accountType">Business Account
    <input type="radio" value="Saving" name="accountType" >Saving Account(AUD only)<br>
    BSB: <input type="number" name="BSB" class="normal" id="BSB"><br>
    Account Number: <input type="number" name="accountNumber" id="accountNumber" class="normal"><br>
    Amount: <input type="number" name="Amount" id="Amount" class="normal">

        <select name="moneyType" id="moneyType">
            <option value="AUD">AUD</option>
            <option value="USD">USD</option>
            <option value="GBP">GBP</option>
        </select><br>

    Purpose:<input type="text" name="purpose" id="purpose" class="normal"><br>
    <button type="submit" name="submit">Submit</button>

</form>
</div>

<div style="background-color: azure;width: 35%;  float: right;margin-right: 100px;">
<p style="font-size: 25px">Pay Bill</p>

<form action="paybill_process.php" method="post" >
    <input type="radio" value="Business" checked="checked" name="accountType">Business Account
    <input type="radio" value="Saving" name="accountType">Saving Account<br>
    BSB: <input type="number" name="BSB" id="BSB" class="normal"><br>
    Account Number: <input type="number" name="accountNumber" id="accountNumber" class="normal"><br>
    Amount: <input type="number" name="Amount" id="Amount" class="normal">AUD<br>

    Bill Type:
        <select name="billType">
            <option value="power">Power</option>
            <option value="water">Water</option>
            <option value="phone">Phone</option>
            <option value="NBN">NBN</option>
        </select><br>


    <button type="submit" name="submit">Submit</button>

</form>
</div>
<div style="height: 400px;"></div>
<div class="footer">
    <p>Runxiao Liu 483386</p>
</div>
</body>

</html>
