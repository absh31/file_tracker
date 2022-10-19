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
            $DocDone = 0;

            if ($fileDoc != '') {
                $fileSize = $_FILES['fileDoc']['size'];

                if ($fileSize > 10485760){
                    echo '<script>alert("File Size limit exceeded.");</script>';
                    echo "<script>window.open('../addFile.php','_self')</script>";
                    exit();
                }
                
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
                // echo "<script>window.open('../files.php','_self')</script>";
            }

            $today = date('Y-m-d H:i:s');
            $addActSql = $conn->prepare("INSERT INTO `tblactivity` (`activity_file_track_no`, `activity_from`, `activity_to`, `activity_remarks`, `activity_type`, `activity_ack`, `activity_ack_time`) VALUES (?, ?, ?, '', 'Added', 1, ?)");
            $addActSql->bindParam(1, $fileTrack);
            $addActSql->bindParam(2, $fileOfficerId);
            $addActSql->bindParam(3, $fileOfficerId);
            $addActSql->bindParam(4, $today);
            $addActSql->execute();

            if($DocDone == 1){
                $addDocSql = $conn->prepare("INSERT INTO `tbldocument` (`document_file_track_no`, `document_title`, `document_path`, `document_by`) VALUES (?, ?, ?, ?)");
                $addDocSql->bindParam(1, $fileTrack);
                $addDocSql->bindParam(2, $fileTitle);
                $addDocSql->bindParam(3, $fileDocPath);
                $addDocSql->bindParam(4, $fileOfficerId);
                $addDocSql->execute();
    
                $fileUploadRemarks = "Document Uploaded";
                $addActSql = $conn->prepare("INSERT INTO `tblactivity` (`activity_file_track_no`, `activity_from`, `activity_to`, `activity_remarks`, `activity_type`, `activity_ack`, `activity_ack_time`) VALUES (?, ?, ?, ?, 'Uploaded', 1, ?)");
                $addActSql->bindParam(1, $fileTrack);
                $addActSql->bindParam(2, $fileOfficerId);
                $addActSql->bindParam(3, $fileOfficerId);
                $addActSql->bindParam(4, $fileUploadRemarks);
                $addActSql->bindParam(5, $today);
                $addActSql->execute();
            }

            echo "<script>window.open('../myFile.php','_self')</script>";
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>
