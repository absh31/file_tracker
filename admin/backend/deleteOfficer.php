<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        if (isset($_POST['officerId'])) {
            $officerId = $_POST['officerId'];

            $deleteOfficerSql = $conn->prepare("UPDATE tblofficer SET officer_active = 0 WHERE officer_id = ?");
            $deleteOfficerSql->bindParam(1, $officerId);
            if ($deleteOfficerSql->execute()) {
                echo "<script>window.alert(`Officer Deleted Successfully`)</script>";
                echo "<script>window.open('../officer.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>
