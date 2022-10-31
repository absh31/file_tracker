<?php
session_start();
include '../../connection.php';
if (isset($_POST['fileUpload']) && $_SESSION['id']) {

    $fileDoc = $_FILES['upFile']['name'];
    $fileDocPath = '';
    $fileTrack = $_POST['fileTrack'];
    $fileTitle = $_POST['fileTitle'];

    if ($fileDoc != '') {
        $fileSize = $_FILES['upFile']['size'];

        if ($fileSize > 10485760) {
            echo '<script>alert("File Size limit exceeded.");</script>';
            echo "<script>window.open('../workFile.php?trackNo=" . $fileTrack . "','_self')</script>";
            exit();
        }

        $fileType = $_FILES['upFile']['type'];
        $fileTmp = $_FILES['upFile']['tmp_name'];
        $extEx = explode('.', $fileTmp);
        $ext = $extEx[1];
        $allowedFiles = array('pdf', 'jpeg', 'png', 'jpg', 'docx', 'xlsx');
        if (!in_array($ext, $allowedFiles)) {
            echo '<script>alert("Please upload valid file.");</script>';
            echo "<script>window.open('../dashboard.php','_self')</script>";
            unset($_POST['fileUpload']);
            exit();
        }

        if (!file_exists('../../uploads/fileDocs')) {
            mkdir('../../uploads/fileDocs', 0777, true);
        }
        $fileDoc = time() . '_' . $fileDoc;
        $fileDocPath = '../../uploads/fileDocs/' . $fileDoc;

        if (!move_uploaded_file($fileTmp, $fileDocPath)) {
            echo '<script>alert("File is not uploaded.");</script>';
            echo "<script>window.open('../addFile.php','_self')</script>";
        } else {
            $DocDone = 1;
        }
        if ($DocDone == 1) {
            $addDocSql = $conn->prepare("INSERT INTO `tbldocument` (`document_file_track_no`, `document_title`, `document_path`, `document_by`) VALUES (?, ?, ?, ?)");
            $addDocSql->bindParam(1, $fileTrack);
            $addDocSql->bindParam(2, $fileTitle);
            $addDocSql->bindParam(3, $fileDocPath);
            $addDocSql->bindParam(4, $_SESSION['id']);
            $addDocSql->execute();

            $today = date('Y-m-d H:i:s');
            $fileUploadRemarks = "Document Uploaded";
            $addActSql = $conn->prepare("INSERT INTO `tblactivity` (`activity_file_track_no`, `activity_from`, `activity_to`, `activity_remarks`, `activity_type`, `activity_ack`, `activity_ack_time`) VALUES (?, ?, ?, ?, 'Uploaded', 1, ?)");
            $addActSql->bindParam(1, $fileTrack);
            $addActSql->bindParam(2, $_SESSION['id']);
            $addActSql->bindParam(3, $_SESSION['id']);
            $addActSql->bindParam(4, $fileUploadRemarks);
            $addActSql->bindParam(5, $today);
            $addActSql->execute();

            echo "<script>window.open('../workFile.php?trackNo=" . $fileTrack . "','_self')</script>";
        }
    } else {
        echo "<script>window.alert(`Bad Request`)</script>";
        echo "<script>window.open('../myFile.php','_self')</script>";
    }
}
