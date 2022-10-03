<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {
        if (isset($_POST['addFile'])) {
            $fileTitle = htmlspecialchars($_POST['fileTitle']);
            $filePerson = htmlspecialchars($_POST['filePerson']);
            $fileDesc = htmlspecialchars($_POST['fileDesc']);
            $filecat_id = htmlspecialchars($_POST['fileCat']);
            $fileOfficerId = $_SESSION['id'];
            $fileDept = htmlspecialchars($_POST['fileDept']);

            $fileRemarks = htmlspecialchars($_POST['fileRemarks']);
            $fileTrack = time();

            $fileDoc = $_FILES['fileDoc']['name'];
            $fileDocPath = '';

            if ($fileDoc != '') {
                $fileSize = $_FILES['fileDoc']['size'];
                $fileType = $_FILES['fileDoc']['type'];
                $fileTmp = $_FILES['fileDoc']['tmp_name'];
    
                if (!file_exists('../../uploads/fileDocs')) {
                    mkdir('../../uploads/fileDocs', 0777, true);
                }
                $fileDoc = time().'_'.$fileDoc;
                $fileDocPath = '../../uploads/fileDocs/'.$fileDoc;

                if (!move_uploaded_file($fileTmp, $fileDocPath)) {
                    echo '<script>alert("File is not uploaded.");</script>';
                    echo "<script>window.open('../addFile.php','_self')</script>";
                } else{
                    $DocDone = 1;
                }             
            }

            $addFileSql = $conn->prepare("INSERT INTO `tblfile` (`file_track_no`, `file_title`, `file_person_name`, `file_desc`, `file_filecat_id`, `file_added_by`, `file_dept_id`, `file_time`, `file_current_holder`, `file_status`, `file_completed`, `file_complete_time`, `file_remarks`, `file_active`) VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp(), ?, 'Added', '0', '', ?, '1')");
            $addFileSql->bindParam(1, $fileTrack);
            $addFileSql->bindParam(2, $fileTitle);
            $addFileSql->bindParam(3, $filePerson);
            $addFileSql->bindParam(4, $fileDesc);
            $addFileSql->bindParam(5, $filecat_id);
            $addFileSql->bindParam(6, $fileOfficerId);
            $addFileSql->bindParam(7, $fileDept);
            $addFileSql->bindParam(8, $fileOfficerId);
            $addFileSql->bindParam(9, $fileRemarks);
            if ($addFileSql->execute()) {
                echo "<script>window.alert(`File Added Successfully`)</script>";
                echo "<script>window.open('../files.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../login.php','_self')</script>";
}
?>
