<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign in</title>
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
        function validate(){ //validate password and username is null or not
            if($("#username").val() == ""){
                alert("please enter your full name.");
                return false;
            }
            else if($("#password").val()==""){
                alert("Please enter your password.");
                return false;
            }
        }

    </script>

</head>
<body>
<fieldset>
    <legend>Sign in</legend>

    <form action="Sign_in_process.php" method="post" onsubmit="return validate();">
        Username: <input type="text" name="username" id="username" class="normal"><br>
        Password: <input type="password" name="password" id="password" class="normal"><br>
        <p></p>

        <input type="submit" name="submit" value="Submit" class="submitbt">
    </form>
    <form action="index.html">
        <input type="submit" name="goto_sign_in" value="Home page" class="submitbt">
    </form>

</fieldset>
<div style="height:60px;"></div>
<div class="footer">
    <p>Runxiao Liu 483386</p>
</div>
</body>
</html>