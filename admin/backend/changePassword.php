<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {
        if (isset($_POST['changePass'])) {
            $currPassword = md5($_POST['currPassword']);
            $newPassword = md5($_POST['newPassword']);
            $sql = $conn->prepare("SELECT * FROM `tblofficer` WHERE officer_username = ?");
            $sql->bindParam(1, $_SESSION['username']);
            $sql->execute();
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            if ($currPassword == $result['officer_password']) {
                $updateSql = $conn->prepare("UPDATE `tblofficer` SET `officer_password` = ? WHERE `officer_username` = ?");
                $updateSql->bindParam(1, $newPassword);
                $updateSql->bindParam(2, $_SESSION['username']);
                if ($updateSql->execute()) {
                    echo "<script>window.alert(`Password changed Successfully!`)</script>";
                    echo "<script>window.open('../dashboard.php','_self')</script>";
                } else {
                    echo "<script>window.alert(`Something went wrong. Please try again later!`)</script>";
                    echo "<script>window.open('../changePassword.php','_self')</script>";
                }
            } else {
                echo "<script>window.alert(`Wrong current Password!`)</script>";
                echo "<script>window.open('../changePassword.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
