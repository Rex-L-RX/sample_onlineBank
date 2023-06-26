<?php
if($_SESSION['access']!=1){
    $message = "You do not have access to this page! Please sign in!"; //alert
    echo "<script type='text/javascript'>alert('$message');</script>";
    $url = "Sign_in.php"; //go to sign in page
    echo "<script type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
    $_SESSION['access']!=0;
}

?>