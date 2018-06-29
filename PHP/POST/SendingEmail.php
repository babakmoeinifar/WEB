<?php
//اول باید فایل php.ini را دستکاری کرد sendmail_path ="\"F:\xampp\sendmail\sendmail.exe\" -t"
//بعد در فایل sendmail.ini در پوشه sendmail :
// auth_username=babakus7@gmail.com
//auth_password=
//smtp_server=smtp.gmail.com
//smtp_port=587
//===========================================================================================
$emailTo = 'babakus7@gmail.com';
$subject = 'Test';
$message = 'This is just testing localhost Email';
$headers = 'From: babakus7@gmail.com';
if (mail($emailTo, $subject, $message, $headers)) {
    echo "پیام با موفقیت ارسال شد";
} else {
    echo "ارسال پیام با خطا مواجه گردید";
}
?>