<?php
$expireTime = time()+86400;
setcookie('name','Ali',$expireTime);
setcookie('age','24',$expireTime);
//==============
setcookie('name',null);

$expireTimeUnset = time()-86400;
setcookie('age','',$expireTimeUnset);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setting Cookie</title>
</head>
<body>

</body>
</html>