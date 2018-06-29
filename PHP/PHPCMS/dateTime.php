<?php require_once("include/functions.php"); ?>
<?php confirmLogin();//for disallowing to enter site without username and password?>
<?php
date_default_timezone_set("Asia/Tehran");
$currentTime = time();
$dateTime = strftime("%Y-%B-%d %H:%m:%S",$currentTime);
?>