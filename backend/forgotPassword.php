<?php
session_start();
include '../connection.php';
include './resetPassword.php';
if (isset($_POST['forgotPassword'])) {
    if (empty($_POST['g-recaptcha-response'])) {
        echo "<script>alert('Captcha Error. Try Again')</script>";
        echo "<script>window.open('../forgotPassword.php','_self')</script>";
    } else {
        $secret_key = '6Lewa-AZAAAAAP729KyiNYyJGV7TnGheI0WUlf6p';
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

        $response_data = json_decode($response);

        if (!$response_data->success) {
            echo "<script>alert('Captcha Error. Try Again')</script>";
            echo "<script>window.open('../','_self')</script>";
        } else {
            $uname = htmlspecialchars($_POST['username']);
            $email = $_POST['email'];
            $sql = $conn->prepare("SELECT * FROM `tblofficer` WHERE `officer_username` = ? AND `officer_email` = ? AND `officer_active` = 1");

            $sql->bindParam(1, $uname);
            $sql->bindParam(2, $email);
            $sql->execute();
            $key = $sql->fetch(PDO::FETCH_ASSOC);

            if ($sql->rowCount() > 0) {
                $sql = $conn->prepare("SELECT * FROM tblofficer WHERE officer_username = ?");
                $sql->bindParam(1, $uname);
                $sql->execute();
                $keys = $sql->fetchAll(PDO::FETCH_ASSOC);
                $resetDone = 1;
                foreach ($keys as $key){
                    if (resetPassword($conn, $key['officer_id'], $key['officer_email']) == 0){
                        $resetDone = 0;
                    } 
                }
                if ($resetDone == '1'){
                    echo "<script>alert('Password has been sent to your Email Account\(s\)');</script>";
                    echo "<script>window.open('../','_self')</script>";
                }else{
                    echo "<script>window.alert('Something went wrong!')</script>";
                }
            } else {
                echo "<script>alert('Invalid Details')</script>";
                echo "<script>window.open('../forgotPassword.php','_self')</script>";
            }
        }
    }
}
?>