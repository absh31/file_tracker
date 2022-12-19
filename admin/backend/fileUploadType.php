<?php
session_start();
include '../../connection.php';
if ((isset($_SESSION['username']) && isset($_SESSION['auth']))) {
    include "./checkAdminLogin.php";
    if (checkAdminLogin($_SESSION['auth']) == "Admin") {
        if (isset($_POST['fileUploadType'])) {
            if (!isset($_POST['fileUpload'])) {
                $xml = new SimpleXMLElement('<xml/>');
                Header('Content-type: text/xml');
                $xml->asXML('../../settings.xml');
            } else {
                $allowedTypes = $_POST['fileUpload'];
                $N = count($allowedTypes);
                $xml = new SimpleXMLElement('<xml/>');
                for ($i = 0; $i < $N; ++$i) {
                    $track = $xml->addChild('fileType', $allowedTypes[$i]);
                }
                Header('Content-type: text/xml');
                $xml->asXML('../../settings.xml');
            }
            header("Location: ../fileUploadType.php");
        }
    }
} else {
    echo "<script>window.alert(`Don't peep!`)</script>";
    echo "<script>window.open('../','_self')</script>";
}
