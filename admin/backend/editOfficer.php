<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        if (isset($_POST['editOfficer'])) {
            // print_r($)
            $officerId = htmlspecialchars($_POST['officerId']);
            $officerName = htmlspecialchars($_POST['officerName']);
            $officerMobile = htmlspecialchars($_POST['officerMobile']);
            $officerEmail = htmlspecialchars($_POST['officerEmail']);
            $officerDept = htmlspecialchars($_POST['officerDept']);
            $officerRole = htmlspecialchars($_POST['officerRole']);
            $officerRemarks = htmlspecialchars($_POST['officerRemarks']);
            $isActive = 1;

            $editOfficerSql = $conn->prepare("UPDATE tblofficer SET officer_name = ?, officer_email = ?, officer_mobile = ?, officer_role_id = ?, officer_dept_id = ?, officer_remarks = ? WHERE officer_id = ?");
            $editOfficerSql->bindParam(1, $officerName);
            $editOfficerSql->bindParam(2, $officerEmail);
            $editOfficerSql->bindParam(3, $officerMobile);
            $editOfficerSql->bindParam(4, $officerRole);
            $editOfficerSql->bindParam(5, $officerDept);
            $editOfficerSql->bindParam(6, $officerRemarks);
            $editOfficerSql->bindParam(7, $officerId);
            if ($editOfficerSql->execute()) {
                echo "<script>window.alert(`Data Edited Successfully`)</script>";
                echo "<script>window.open('../officer.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>