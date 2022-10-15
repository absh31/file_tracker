<?php
function resetPassword($conn, $officer_id, $officer_email)
{
    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
    $newPass = substr(str_shuffle($data), 0, 10);
    $newPassHash = md5($newPass);
    $to_email = $officer_email;
    $subject = 'Password Reset Done!';
    $message = 'Hello,<br> Your password for File Tracker System hase been reset.<br>Your New Password for File Tracker System : ';
    $message .= "<b>".$newPass."</b>";
    $message .= '<br><br>Regards,<br>File Tracker Team';
    $headers = 'From : File Tracker Team';
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    if (mail($to_email, $subject, $message, $headers)) {

        $sql = $conn->prepare("UPDATE tblofficer SET officer_password = ? WHERE officer_id = ?");
        $sql->bindParam(1, $newPassHash);
        $sql->bindParam(2, $officer_id);
        if ($sql->execute()) {
            return 1;
        } else {
            return 0;
        }

    }else{
        return 0;
    }
}
