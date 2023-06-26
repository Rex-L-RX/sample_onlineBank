<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saving Account</title>
    <link rel="stylesheet" type="text/css" href="css/Account.css">
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
<?php
    include ("db_conn.php");
    include ("session.php");

    $fromAccountNumber=$_SESSION['fromAccountNumber1'];

    $toBSB=$_SESSION['toBSB1'];//get BSB number
    $toAccountNumber=$_SESSION['toAccountNumber1']; //get to account number

    $Amount=$_SESSION['Amount1'];   //get to amount

    $billType=$_SESSION['billType1']; //get bill type
    $purpose=$_SESSION['purpose1'];// get transfer purpose

    $moneyType="AUD";
    $moneyType=$_SESSION['moneyType'];



?>



<P style="color: red; font-size: 23px"><?Php
    if($Amount>25000){
        echo "This transaction need to be approved by manager!!!";
    }
    else{
        echo "Your transfers or payments success!";
    }

?></P>
<p>From:<?Php echo "017324"."-"."$fromAccountNumber"; ?></p>
<p>To:<?Php  echo "$toBSB"."-"."$toAccountNumber"; ?></p>
<p>Amount:<?Php   echo "$Amount"."$moneyType"; ?></p>
<p>Purpose:<?Php  echo "$billType"."$purpose";  ?></p>
<div style="height:60px;"></div>
<div class="footer">
    <p>Runxiao Liu 483386</p>
</div>
</body>
</html>







