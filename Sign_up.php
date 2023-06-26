<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create an Account</title>
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="css/Account.css" rel="stylesheet" type="text/css">
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
    <fieldset id="signupFieldSet">
        <legend>Create an Account</legend>
        <form action="Sign_up_process.php" method="post" onsubmit="return validate();">
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

            <input type="submit" name="submit" value="Submit" class="submitbt" style="float: left">

        </form>
        <form action="index.html" style="float: left">
            <input type="submit"  value="Home page" class="submitbt">
        </form>

    </fieldset>
    <div style="height:60px;"></div>
    <div class="footer">
        <p>Runxiao Liu 483386</p>
    </div>
</body>
</html>