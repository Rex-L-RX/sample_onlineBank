<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
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
            include ("db_conn.php");


            $query = "SELECT * FROM users WHERE username ='$session_username'";
            $result = $mysqli->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $session_last_login_date_time=$row['lastLoginTime'];

            $_SESSION['last_login_date_time'] = $session_last_login_date_time;

            //show username
            echo "<br>";
            echo "Hello, "."$session_username"."<br>";
            //show last access time
            echo "Your last log in time is:"."$session_last_login_date_time";

            //get business account number and balance
            $query = "SELECT * FROM Account WHERE username ='$session_username' AND accountType='Business'";
            $result = $mysqli->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $accountNumber_B=$row['accountNumber'];
            $accountBalance_B=$row['balance'];
            //put them into session
            $_SESSION['$accountNumber_B']=$accountNumber_B;
            $_SESSION['$accountBalance_B']=$accountBalance_B;

            //get saving account number and balance
            $query = "SELECT * FROM Account WHERE username ='$session_username' AND accountType='Saving'";
            $result = $mysqli->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $accountNumber_S=$row['accountNumber'];
            $accountBalance_S=$row['balance'];
            //put them into session
            $_SESSION['$accountNumber_S']=$accountNumber_S;
            $_SESSION['$accountBalance_S']=$accountBalance_S;


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

    <fieldset style="width: 30%; bottom: 100px;">
        <legend>Open credit card</legend>
        <p style="font-size: 25px">
            <?php
            //if Saving account balance > 50, show you can open a credit card and open credit card button
            $query = "SELECT * FROM Account WHERE username ='$session_username' AND accountType='Saving'";
            $result = $mysqli->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $creditCard=$row['creditCard'];
            $balance=$row['balance'];
            if ($creditCard==0&&$balance>50){
                echo "You can open a credit card";

            }
            elseif ($creditCard==0&&$balance<50){
                echo "You don't have enough balance";
            }
            elseif($creditCard==1){
                echo "You already own a credit card";

            }
            ?></p>

        <?php
        if ($creditCard==0&&$balance>50){
            echo "<form method=\"post\" action=\"lag.php\">
            <input type=\"radio\" name=\"isOpen\" value=\"1\" checked=\"checked\">Open a credit card
            <button type=\"submit\" name=\"submit\" >Submit</button>
        </form>";
        }




        ?>

    </fieldset>
    <div style="height:60px;"></div>
    <div class="footer">
        <p>Runxiao Liu 483386</p>
    </div>




</body>
</html>