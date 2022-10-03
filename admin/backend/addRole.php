<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if(checkAdminLogin($_SESSION['auth']) == "Admin"){
        if(isset($_POST['addRole'])){
            $roleName = $_POST["roleName"];
            $newRolePriority = (int)$_POST["rolePriority"] + 1;
            $getUsersSql = $conn->prepare("SELECT * FROM tblrole WHERE role_priority > ?");
            $getUsersSql->bindParam(1, $_POST["rolePriority"]);
            $getUsersSql->execute();
            $users = $getUsersSql->fetchAll(PDO::FETCH_ASSOC);
            foreach($users as $user){
                $userNewPriority = (int)$user['role_priority'] + 1;
                $updatePrioritySql = $conn->prepare("UPDATE tblrole SET role_priority = ? WHERE role_id = ?");
                $updatePrioritySql->bindParam(1, $userNewPriority);
                $updatePrioritySql->bindParam(2, $user['role_id']);
                $updatePrioritySql->execute();
            }
            $isActive = 1;
            $addUserSql = $conn->prepare("INSERT INTO tblrole (role_name, role_priority, role_active) VALUES (?, ?, ?)");
            $addUserSql->bindParam(1, $roleName);
            $addUserSql->bindParam(2, $newRolePriority);
            $addUserSql->bindParam(3, $isActive);
            if($addUserSql->execute()){
                echo "<script>window.alert(`Role Added Successfully`)</script>";
                echo "<script>window.open('../roles.php','_self')</script>";
            }
    
        }
    } else {
        echo "<script>window.alert(`Don't peep!`)</script>";
        echo "<script>window.open('../login.php','_self')</script>";
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>