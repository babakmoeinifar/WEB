<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File 2</title>
</head>
<body>
<pre>
<?php
print_r($_GET);
?>
</pre>
<br>
<?php
$name = $_GET['name'];
echo $name."<br>";

$position = $_GET['position'];
echo $position;
?>
</body>
</html>