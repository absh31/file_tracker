<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {
        if (isset($_POST['addOfficer'])) {
            $officerName = htmlspecialchars($_POST['officerName']);
            $officerEmail = htmlspecialchars($_POST['officerEmail']);
            $officerMobile = htmlspecialchars($_POST['officerMobile']);
            $officerUsername = htmlspecialchars($_POST['officerUsername']);
            $officerPassword = md5($_POST['officerPassword']);
            $officerDept = htmlspecialchars($_POST['officerDept']);
            $officerRole = htmlspecialchars($_POST['officerRole']);
            $officerRemarks = htmlspecialchars($_POST['officerRemarks']);
            $isActive = 1;

            $addDeptSql = $conn->prepare("INSERT INTO tblofficer (officer_dept_id, officer_role_id, officer_username, officer_password, officer_name, officer_email, officer_mobile, officer_remarks, officer_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $addDeptSql->bindParam(1, $officerDept);
            $addDeptSql->bindParam(2, $officerRole);
            $addDeptSql->bindParam(3, $officerUsername);
            $addDeptSql->bindParam(4, $officerPassword);
            $addDeptSql->bindParam(5, $officerName);
            $addDeptSql->bindParam(6, $officerEmail);
            $addDeptSql->bindParam(7, $officerMobile);
            $addDeptSql->bindParam(8, $officerRemarks);
            $addDeptSql->bindParam(9, $isActive);
            if ($addDeptSql->execute()) {
                echo "<script>window.alert(`Officer Added Successfully`)</script>";
                echo "<script>window.open('../officer.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>
