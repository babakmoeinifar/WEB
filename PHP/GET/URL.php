<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>URL</title>
</head>
<body>
<?php
$web = "Google Iran";
$search = "Babak Moeinifar website & works";
$result = "https://".rawurlencode($web)."?search=".urlencode($search);
echo $result;
?>
</body>
</html>