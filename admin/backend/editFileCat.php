<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {

        if (isset($_POST['editFileCat'])) {
            $fileCatId = htmlspecialchars($_POST['fileCatId']);
            $fileCatName = htmlspecialchars($_POST['catName']);
            $catFormat = htmlspecialchars($_POST['catFormat']);
            $catRemarks = htmlspecialchars($_POST['catRemarks']);

            $fileDocSql = $conn->prepare("SELECT * FROM tblfilecat WHERE filecat_id = ?");
            $fileDocSql->bindParam(1, $fileCatId);
            $fileDocSql->execute();
            $fileDoc = $fileDocSql->fetch(PDO::FETCH_ASSOC);
            $catDocPathOld = $fileDoc['filecat_doc_path'];

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
                }  else{
                    if(file_exists($catDocPathOld)){
                        unlink($catDocPathOld);
                    }
                }            
            } else{
                $catDocPath = $catDocPathOld;
            }

            $editfileCatSql = $conn->prepare("UPDATE tblfilecat SET filecat_name = ?, filecat_format = ?, filecat_remarks = ?, filecat_doc_path = ? WHERE filecat_id = ?");
            $editfileCatSql->bindParam(1, $fileCatName);
            $editfileCatSql->bindParam(2, $catFormat);
            $editfileCatSql->bindParam(3, $catRemarks);
            $editfileCatSql->bindParam(4, $catDocPath);
            $editfileCatSql->bindParam(5, $fileCatId);
            if ($editfileCatSql->execute()) {
                echo "<script>window.alert(`Data Edited Successfully`)</script>";
                echo "<script>window.open('../fileCategory.php','_self')</script>";
            }
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
?>