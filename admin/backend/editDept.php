<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        if (isset($_POST['editDept'])) {
            $deptId = $_POST['deptId'];
            $deptName = $_POST['deptName'];
            $deptEmail = $_POST['deptEmail'];
            $deptDesc = $_POST['deptDesc'];
            $deptRemarks = $_POST['deptRemarks'];
            $isActive = 1;
            $editDeptSql = $conn->prepare("UPDATE tbldept SET dept_name = ?, dept_email = ?, dept_desc = ?, dept_remarks = ? WHERE dept_id = ?");
            $editDeptSql->bindParam(1, $deptName);
            $editDeptSql->bindParam(2, $deptEmail);
            $editDeptSql->bindParam(3, $deptDesc);
            $editDeptSql->bindParam(4, $deptRemarks);
            $editDeptSql->bindParam(5, $deptId);
            if ($editDeptSql->execute()) {
                echo "<script>window.alert(`Data Edited Successfully`)</script>";
                echo "<script>window.open('../dept.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../../','_self')</script>";
}
?>