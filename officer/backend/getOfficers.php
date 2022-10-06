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
    echo "<option value='".$officer['officer_id']."'>".$officer['officer_name']."</option>";
}
?>