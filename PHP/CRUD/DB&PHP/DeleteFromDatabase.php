<!-- 04 LEARN -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap.min.css">
    <meta charset="UTF-8">
    <title>View From Database</title>
</head>
<body>
<div class="container">
    <!--for success Deleted record message that redirect to this page -->
    <!--@ before $_GET means OK if 'Deleted' wasn't in url -->
    <h2 class="font-weight-bold text-info"><?php echo @$_GET['Deleted'] ?></h2>
    <table class="table table-light table-striped border">
        <thead class="thead-light text-center">View from Database</thead>
        <tbody>
        <tr>
            <th>ID</th>
            <th>Employee Name</th>
            <th>SSN</th>
            <th>Department</th>
            <th>Salary</th>
            <th>Home Address</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <?php
        $connection = mysqli_connect('localhost', 'root', '', 'record');
        $viewQuery = "SELECT * FROM emp_record";
        $execute = mysqli_query($connection, $viewQuery);
        while ($dataRows = mysqli_fetch_array($execute)){
        $ID = $dataRows['id'];
        $eName = $dataRows['enam'];
        $SSN = $dataRows['ssn'];
        $Dept = $dataRows['dept'];
        $Salary = $dataRows['salary'];
        $homeAdd = $dataRows['homeaddress'];
        ?>
        <tr>
            <td><?php echo $ID; ?></td>
            <td><?php echo $eName; ?></td>
            <td><?php echo $SSN; ?></td>
            <td><?php echo $Dept; ?></td>
            <td><?php echo $Salary; ?></td>
            <td><?php echo $homeAdd; ?></td>
            <td>Update</td>
            <td><a href="Delete.php?Delete=<?php echo $ID;?>">Delete</a></td>
        </tr>
        </tbody>

        <?php } ?>
    </table>
</div>
</body>
</html>