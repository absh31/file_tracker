<?php
session_start();
include "../../header.php";
include '../../connection.php';

if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    if (isset($_GET['id'])) {
        $_SESSION['id'] = $_GET['id'];
        echo "<script>window.open('../dashboard.php','_self')</script>";
    } else {
        echo "<script>window.alert(`Bad Request`)</script>";
        unset($_SESSION['username']);
        unset($_SESSION['auth']);
        echo "<script>window.open('../../.php','_self')</script>";
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
