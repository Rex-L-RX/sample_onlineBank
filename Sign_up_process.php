<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <?php


        include("db_conn.php");         //connect to database
        include ("session.php");//start session
        include "GetAccountNumber.php";//created an account number
        $username = $_POST["username"]; //get username
        $password = $_POST["password"]; // get username
        $mobile = $_POST["mobile"];     // get mobile number
        $email = $_POST["email"];       // get email
        $gender= $_POST["gender"];      //get gender
        $AccountType=$_POST["AccountType"];  //get account type
        $DoB=$_POST["DoB"];               //get date of birth
        //get creative time
        $_SESSION['signUp_date_time']=date("Y-m-d H:i:s");
        $signUp_date_time=$_SESSION['signUp_date_time'];
        //validate username
        $query = "SELECT * FROM users WHERE username ='$username'";
        $result = $mysqli->query($query);
        if(mysqli_num_rows($result) > 0){
            $message = "This username has been used, please try another one!"; //alert
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "Sign_up.php";   //go to sign in page
            echo "<script type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }
        else{
            //insert variables into database
            $query= "insert into users(username, `DoB`,password, mobile, email, gender, AccountType, createTime) VALUES('$username','$DoB','$password','$mobile','$email', '$gender','$AccountType','$signUp_date_time') ";
            $mysqli->query($query);
            $message = "You have successfully creat an account, please sign in!"; //alert
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "Sign_in.php";   //go to sign in page
            echo "<script type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";

            $accountNumber_B=GetAccountNumber();
            $BSB="017324";

            $AccountType_B="Business";
            $query="INSERT INTO `Account`( `username`, `accountType`, `BSB`, `accountNumber`) VALUES ('$username','$AccountType_B','$BSB','$accountNumber_B')";
            $mysqli->query($query);

            $AccountType_S="Saving";
            $accountNumber_S=GetAccountNumber()+1;
            $query="INSERT INTO `Account`( `username`, `accountType`, `BSB`, `accountNumber`) VALUES ('$username','$AccountType_S','$BSB','$accountNumber_S')";
            $mysqli->query($query);


        }




    ?>


</body>
</html>
