<?php
session_start();
include '../../connection.php';
$deptId = $_POST['deptId'];
$officersSql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_dept_id = ? AND officer_active = 1");
$officersSql->bindParam(1, $deptId);
$officersSql->execute();
// echo "<option disabled selected>Select Officer</option>";
$officers = $officersSql->fetchAll(PDO::FETCH_ASSOC);
foreach ($officers as $officer) {
    $officerRoleSql = $conn->prepare("SELECT * FROM tblrole WHERE role_id = ?");
    $officerRoleSql->bindParam(1, $officer['officer_role_id']);
    $officerRoleSql->execute();
    $officerRole = $officerRoleSql->fetch(PDO::FETCH_ASSOC); 
    echo "<option value='".$officer['officer_id']."'>".$officer['officer_name']." - ".$officerRole['role_name']."</option>";
}
?>