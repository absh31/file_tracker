<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        if (isset($_POST['editFile'])) {
            $fileId = htmlspecialchars($_POST['fileId']);
            $fileTitle = htmlspecialchars($_POST['fileTitle']);
            $filePerson = htmlspecialchars($_POST['filePerson']);
            $fileDesc = htmlspecialchars($_POST['fileDesc']);
            $fileRemarks = htmlspecialchars($_POST['fileRemarks']);
            $fileCat = htmlspecialchars($_POST['fileCat']);
            $editFileSql = $conn->prepare("UPDATE tblfile SET file_title = ?, file_person_name = ?, file_desc = ?, file_remarks = ?, file_filecat_id = ? WHERE file_id = ?");
            $editFileSql->bindParam(1, $fileTitle);
            $editFileSql->bindParam(2, $filePerson);
            $editFileSql->bindParam(3, $fileDesc);
            $editFileSql->bindParam(4, $fileRemarks);
            $editFileSql->bindParam(5, $fileCat);
            $editFileSql->bindParam(6, $fileId);
            if ($editFileSql->execute()) {
                echo "<script>window.alert(`Data Edited Successfully`)</script>";
                echo "<script>window.open('../files.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../../','_self')</script>";
}
?>