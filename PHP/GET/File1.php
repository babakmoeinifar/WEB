<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File 1</title>
</head>
<body>
<?php
$name = "Ali Babak";
$position = "Support coordinator & Manager";
?>
//search url
<a href="File2.php?name=<?php echo $name;?>&position=<?php echo urlencode($position);?>">Click</a><br>
</body>
</html>