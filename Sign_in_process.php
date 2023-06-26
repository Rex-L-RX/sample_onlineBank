<?php

    include("db_conn.php");//connect to database
    include ("session.php");   // start session
    $username = $_POST["username"]; //get username
    $sql = "SELECT password FROM users where username='$username' "; //get password from database
    $sql_accountType = "SELECT AccountType FROM users where username='$username' ";//get account type from database
    $result = mysqli_query($mysqli, $sql);
    $password = $_POST["password"];
    if(mysqli_num_rows($result) > 0){  // output data of each row
        $result_accountType = mysqli_query($mysqli, $sql_accountType);
        $row_accountType = mysqli_fetch_assoc($result_accountType);

        $_SESSION['accountType'] = $row_accountType["AccountType"];
        $session_accountType=$row_accountType["AccountType"];
        $_SESSION['username'] = $username;
    }




    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);

        if($row["password"] != "$password"){//validate password
            $message = "Password error, please try again!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $url = "Sign_in.php"; //go to sign in page
            echo "<script type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";

        }
        else{

            if($session_accountType=='manager'){
                $_SESSION['access']=2;
                $_SESSION['login_date_time']=date("Y-m-d H:i:s");
                $url1 = "Manager_account.php";// go to manager account page
                echo "<script type='text/javascript'>";
                echo "window.location.href='$url1'";
                echo "</script>";

            }
            else{
                $url1 = "Account.php";// go to account page
                echo "<script type='text/javascript'>";
                echo "window.location.href='$url1'";
                echo "</script>";
                $_SESSION['access']=1;
                //get login time
                $_SESSION['login_date_time']=date("Y-m-d H:i:s");
//            $session_login_date_time=$_SESSION['login_date_time'];
//            echo "$session_login_date_time";
//            $updatequery="UPDATE `users` SET `lastLoginTime`='$session_login_date_time' WHERE username='$username'" ;
//            $mysqli->query($updatequery);
            }

        }

    }
    else {
        $message1 = "Username error, please try again!"; //validate username
        echo "<script type='text/javascript'>alert('$message1');</script>";
        $url = "Sign_in.php"; //go to sign in page
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    }

    mysqli_close($mysqli); //close database


?>