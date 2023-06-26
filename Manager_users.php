<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage users</title>
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
<P></P>

<!--update user details-->
<fieldset style="width: 30%;float: left; margin-left: 10%;margin-top: 15px;" >
    <legend>Update a user's detail</legend>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <P>You can update DoB, Mobile, Email, Gender and Account type  username </P>
        <p>
            <label>Username:</label>
            <input type="text" name="Username">
        </p>
        <p>
            <label>DoB:</label>
            <input type="text" name="DoB">
        </p>
        <p>
            <label>Mobile:</label>
            <input type="text" name="Mobile">
        </p>
        <p>
            <label>Email:</label>
            <input type="text" name="Email">
        </p>
        <p>
            <label>Gender:</label>

            <input type="radio" name="Gender" checked="checked" value="male">Male
            <input type="radio" name="Gender"  value="female">Female
            <input type="radio" name="Gender"  value="other">Other

        </p>
        <p>
            <label>Account type:</label>

            <input type="radio" name="AccountType" value="normal" checked="checked">Normal
            <input type="radio" name="AccountType" value="manager">Manager
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
    $DoB = $_POST["DoB"];
    $Mobile = $_POST["Mobile"];
    $Email = $_POST["Email"];
    $Gender = $_POST["Gender"];
    $AccountType = $_POST["AccountType"];
    $Last_login_time = $_POST["Last_login_time"];
    $createTime = $_POST["createTime"];

    $query = "UPDATE `users` SET `DoB`='$DoB',`mobile`='$Mobile',`email`='$Email',`gender`='$Gender',`AccountType`='$AccountType' WHERE `username`='$Username' ";
    $result = $mysqli->query($query);

    if ($result){
        echo '<meta http-equiv="refresh" content="0">';

    }
    else{
        echo "Update Failed";
    }
    $mysqli->close();
}


?><!--delete an account-->
<fieldset style="width: 30%;float: left; margin-left: 10%;margin-top: 15px;" >
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


    $Username = $_POST["username"];


    $query = "DELETE FROM `Account` WHERE username = '$Username'";
    $result = $mysqli->query($query);

    $query2 = "DELETE FROM  `users` WHERE username = '$Username'";
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



<!--show users-->
<div style="height: 20px;margin-top: 20%;"></div>
<table>
    <tr>
        <td>ID</td>
        <td>Username</td>
        <td>DoB</td>

        <td>Mobile</td>
        <td>Email</td>
        <td>Gender</td>
        <td>AccountType</td>
        <td>Last Login time</td>
        <td>Create time</td>
    </tr>

</table>

<?php
include ("db_conn.php");
//query for retreiving all the items from the Account table (order by the recent items)
$list_query = "SELECT * FROM `users`";
//execute the query 'list_query'
$result= $mysqli->query($list_query);

//covert the above result into array (associative array)
//keys of the array are the column name
while($row= $result->fetch_array(MYSQLI_ASSOC)){

    //extract the values
    $id=$row['userID'];
    $Username=$row['username'];
    $DoB=$row['DoB'];

    $mobile=$row['mobile'];
    $email=$row['email'];

    $gender=$row['gender'];
    $AccountType=$row['AccountType'];
    $lastLoginTime=$row['lastLoginTime'];
    $createTime=$row['createTime'];






    //printing out with table
    ?>
    <br>
    <table>

        <tr>
            <td><?php echo $id;?></td>
            <td><?php echo $Username;?></td>
            <td><?php echo $DoB;?></td>

            <td><?php echo $mobile;?></td>
            <td><?php echo $email;?></td>
            <td><?php echo $gender;?></td>
            <td><?php echo $AccountType;?></td>
            <td><?php echo $lastLoginTime;?></td>
            <td><?php echo $createTime;?></td>

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
