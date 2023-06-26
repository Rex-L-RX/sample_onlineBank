<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Account</title>
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

<!--update account details-->
<fieldset style="width: 30%;float: left; margin-left: 10%; margin-top: 15px;" >
    <legend>Update an Account</legend>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <P>You can update account number, balance and the number of credit cards by username and account type</P>
        <p>
            <label>Username:</label>
            <input type="text" name="Username">
        </p>
        <p>
            <label>Account type:</label>
            <input type="text" name="AccountType">
        </p>
        <p>
            <label>Account number:</label>
            <input type="text" name="AccountNumber">
        </p>
        <p>
            <label>Balance:</label>
            <input type="text" name="Balance">
        </p>
        <p>
            <label>Credit card:</label>
            <input type="text" name="creditCard">
        </p>
        <p>
            <button type="submit" name="update" style="width: 100px; height: 40px">Update</button>
        </p>
    </form>
</fieldset>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    include('db_conn.php');

    $Username = $_POST["Username"];
    $AccountType = $_POST["AccountType"];
    $AccountNumber = $_POST["AccountNumber"];
    $Balance = $_POST["Balance"];
    $creditCard = $_POST["creditCard"];
    //update account details
    $query = "UPDATE `Account` SET `accountNumber`='$AccountNumber',`balance`='$Balance',`creditCard`='$creditCard ' WHERE `username`='$Username' AND `accountType`='$AccountType'";
    $result = $mysqli->query($query);

    if ($result){
        echo '<meta http-equiv="refresh" content="0">';

    }
    else{
        echo "Update Failed";
    }
    $mysqli->close();
}


?>

<!--delete an account-->
<fieldset style="width: 30%;float: left; margin-left: 10%; margin-top: 15px;" >
    <legend>Delete an Account</legend>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <p>
            <label>User name:</label>
            <input type="text" name="username">
        </p>

        <p>
            <button type="submit" name="delete" style="width: 100px; height: 40px">Delete</button>
        </p>
    </form>
</fieldset>

<?php
include "db_conn.php";
//delete an account
if ($_SERVER["REQUEST_METHOD"] == "POST"){


    $Username = $_POST['username'];


    $query = "DELETE FROM `Account` WHERE `username` = '$Username'";
    $result = $mysqli->query($query);

    $query2 = "DELETE FROM `users` WHERE username = '$Username'";
    $result2 = $mysqli->query($query2);

    if ($result){
        echo '<meta http-equiv="refresh" content="0">';

    }
    else{
        echo "Delete Failed";
    }
    $mysqli->close();

}


?>
<!--show accounts-->
<div style="height: 20px; margin-top: 20%"></div>
<table>
    <tr>
        <td>ID</td>
        <td>Username</td>
        <td>Account type</td>
        <td>BSB & Account number</td>
        <td>Balance</td>
        <td>Credit card</td>

    </tr>

</table>
<?php
include ("db_conn.php");
//query for retreiving all the items from the Account table (order by the recent items)
$list_query = "SELECT * FROM `Account`";
//execute the query 'list_query'
$result= $mysqli->query($list_query);

//covert the above result into array (associative array)
//keys of the array are the column name
while($row= $result->fetch_array(MYSQLI_ASSOC)){

    //extract the values
    $id=$row['accountId'];
    $username=$row['username'];
    $accountType=$row['accountType'];
    $accountNumber=$row['accountNumber'];
    $Account="017324"."-".$accountNumber;

    $balance=$row['balance'];
    $creditCard=$row['creditCard'];

    //printing out with table
    ?>
    <br>
    <table>

        <tr>
            <td><?php echo $id;?></td>
            <td><?php echo $username;?></td>
            <td><?php echo $accountType;?></td>
            <td><?php echo $Account;?></td>
            <td><?php echo $balance;?></td>
            <td><?php echo $creditCard;?></td>

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

