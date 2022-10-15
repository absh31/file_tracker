<?php     
$to_email = 'abhishah3102@gmail.com';
$subject = 'Testing PHP Mail absh';
$message = 'This mail is sent using the PHP mail function';
$headers = 'From: noreply @ company . com';
mail($to_email,$subject,$message,$headers);
?>