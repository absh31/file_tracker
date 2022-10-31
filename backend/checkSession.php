<?php
function checkSession()
{
    if(isset($_SESSION['expire'])){
        $now = time();
        if ($now > $_SESSION['expire']) {
            echo "<script>alert('Your session is expired, please login again.');</script>";
            echo "<script>window.open('../logout.php','_SELF');</script>";
        }
    }else{
        echo "<script>window.open('../logout.php','_SELF');</script>";
    }
}
?>