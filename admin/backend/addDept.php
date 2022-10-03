<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {
        if (isset($_POST['addDept'])) {
            $deptName = htmlspecialchars($_POST['deptName']);
            $deptEmail = htmlspecialchars($_POST['deptEmail']);
            $deptRemarks = htmlspecialchars($_POST['deptRemarks']);
            $deptDesc = htmlspecialchars($_POST['deptDesc']);
            $isActive = 1;
            $addDeptSql = $conn->prepare("INSERT INTO tbldept (dept_name, dept_email, dept_desc, dept_active, dept_remarks) VALUES (?, ?, ?, ?, ?)");
            $addDeptSql->bindParam(1, $deptName);
            $addDeptSql->bindParam(2, $deptEmail);
            $addDeptSql->bindParam(3,  $deptDesc);
            $addDeptSql->bindParam(4, $isActive);
            $addDeptSql->bindParam(5, $deptRemarks);
            if ($addDeptSql->execute()) {
                echo "<script>window.alert(`Department Added Successfully`)</script>";
                echo "<script>window.open('../dept.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../../','_self')</script>";
}
?>