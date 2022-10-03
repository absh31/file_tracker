<?php
session_start();
if (!isset($_SESSION['username'])){
    echo "<script>window.open('../index.php','_self')</script>";
}else{
    echo $_SESSION['officer_name'];
}
?>