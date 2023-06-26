<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add an account</title>
    <link rel="stylesheet" type="text/css" href="css/Account.css">
    <link rel="stylesheet" type="text/css" href="css/table.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
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
            if($("#username").val() == ""){
                alert("please enter your full name.");
                return false;
            }
            else if($("#password").val().length<8){
                alert("Your Password Must Contain At Least 8 Characters!");
                return false;
            }
            else if(!(/^(?=.*[0-9])(?=.*[!~!#$*])((?=.*[a-z])(?=.*[A-Z]))[a-zA-Z0-9!!~#$*]{8,12}$/.test($("#password").val()))){ //password validate
                alert("Your password must contain at least one capital letter, lowercase letter, digit and special character. ");
                return false;
            }
            else if ($("#password").val()!= $("#confirm_password").val()){
                alert("password does not mach.");
                return false;
            }
            else if ($("#mobile").val()==""){
                alert("please enter your mobile number.");
                return false;
            }
            else if($("#email").val()==""){
                alert("Please enter your email address.");
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
<fieldset id="signupFieldSet" style="width: 30%;float: left; margin-left: 10%; margin-top: 15px; border-color: cadetblue;" >
    <legend>Create an Account</legend>
    <form action="Manager_Sign_process.php" method="post" onsubmit="return validate();">
        Username: <input type="text" name="username" id="username" class="normal"><br>
        Password: <input type="password" name="password" id="password" class="normal"><br>
        Confirm password: <input type="password" name="confirm_password" id="confirm_password" class="normal"><br>
        Mobile: <input type="text" name="mobile" id="mobile" class="normal"><br>
        Email: <input type="text" name="email" id="email" class="normal"><br>
        Date of birth: <input type="date" name="DoB" id="DoB" class="normal"><br>
        Gender:
        <input type="radio" name="gender" value="male" class="gender" checked="checked" >Male
        <input type="radio" name="gender" value="female" class="gender">Female
        <input type="radio" name="gender" value="other" class="gender">Other<br>

        AccountType:
        <input type="radio" name="AccountType" value="normal" checked="checked" class="2">Normal

        <p></p>

        <input type="submit" name="submit" value="Submit" class="submitbt" style="float: left;background: lightseagreen">

    </form>


</fieldset>
<div style="height:60px;"></div>
<div class="footer">
    <p>Runxiao Liu 483386</p>
</div>


</body>
</html>

