<?php
session_start();
include '../connection.php';
if (isset($_POST['AuthLogin'])) {
    if (empty($_POST['g-recaptcha-response'])) {
        echo "<script>alert('Captcha Error. Try Again')</script>";
        echo "<script>window.open('../','_self')</script>";
    } else {
        $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

        $response_data = json_decode($response);

        if (!$response_data->success) {
            echo "<script>alert('Captcha Error. Try Again')</script>";
            echo "<script>window.open('../','_self')</script>";
        } else {
            $uname = htmlspecialchars($_POST['username']);
            $pass = md5($_POST['password']);
            $type = htmlspecialchars($_POST['type']);
            $sql = $conn->prepare("SELECT * FROM `tblofficer` WHERE `officer_username` = ? AND `officer_password` = ? AND `officer_role_id` = ?");

            $sql->bindParam(1, $uname);
            $sql->bindParam(2, $pass);
            $sql->bindParam(3, $type);
            $sql->execute();
            $key = $sql->fetch(PDO::FETCH_ASSOC);

            if ($sql->rowCount() > 0) {
                $_SESSION['officer_name'] = $key['officer_name'];
                $_SESSION['username'] = $uname;
                $_SESSION['auth'] = $type;
                $_SESSION['id'] = $key['officer_id'];
                if ($type == '1'){
                    echo "<script>window.open('../admin/dashboard.php','_self')</script>";
                }else{
                    echo "<script>window.open('../officer/dashboard.php','_self')</script>";
                }
            } else {
                echo "<script>alert('Invalid Credentials')</script>";
                echo "<script>window.open('../','_self')</script>";
            }
        }
    }
}
