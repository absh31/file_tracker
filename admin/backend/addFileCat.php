<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {
        if (isset($_POST['addCat'])) {
            $catName = htmlspecialchars($_POST['catName']);
            $catFormat = htmlspecialchars($_POST['catFormat']);
            $catRemarks = htmlspecialchars($_POST['catRemarks']);
            
            $catDoc = $_FILES['catDoc']['name'];
            $catDocPath = '';

            if ($catDoc != '') {
                $catSize = $_FILES['catDoc']['size'];
                $catType = $_FILES['catDoc']['type'];
                $catTmp = $_FILES['catDoc']['tmp_name'];
    
                if (!file_exists('../../uploads/catDocs')) {
                    mkdir('../../uploads/catDocs', 0777, true);
                }
                $catDoc = time().'_'.$catDoc;
                $catDocPath = '../../uploads/catDocs/'.$catDoc;

                if (!move_uploaded_file($catTmp, $catDocPath)) {
                    echo '<script>alert("File is not uploaded.");</script>';
                    echo "<script>window.open('../addFileCat.php','_self')</script>";
                }              
            }


            $isActive = 1;

            $addFileCatSql = $conn->prepare("INSERT INTO tblfilecat (filecat_name, filecat_format, filecat_doc_path, filecat_remarks, filecat_active) VALUES (?, ?, ?, ?, ?)");
            $addFileCatSql->bindParam(1, $catName);
            $addFileCatSql->bindParam(2, $catFormat);
            $addFileCatSql->bindParam(3, $catDocPath);
            $addFileCatSql->bindParam(4, $catRemarks);
            $addFileCatSql->bindParam(5, $isActive);
            if ($addFileCatSql->execute()) {
                echo "<script>window.alert(`Category Added Successfully`)</script>";
                echo "<script>window.open('../fileCategory.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>
