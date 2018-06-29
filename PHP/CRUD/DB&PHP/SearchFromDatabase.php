<!-- 08 LEARN -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Search From Database</title>
</head>
<body>
<div class="container">

    <form class="form-group mt-4 row" action="SearchFromDatabase.php" method="get">
        <fieldset>
            <input class="form-control" type="search" name="Search" value="" placeholder="جستجو با نام / کد پرسنلی">
            <input class="btn float-left" type="submit" name="SearchButton" value="Search">
        </fieldset>
    </form>
    <?php
    $connection = mysqli_connect('localhost', 'root', '', 'record');
    if (isset($_GET['SearchButton'])) {
        $search = $_GET['Search'];
        $searchQuery = "SELECT * FROM emp_record WHERE enam = '$search'OR ssn = '$search'";
        $execute = mysqli_query($connection, $searchQuery);
            while ($dataRows = mysqli_fetch_array($execute)) {
                $ID = $dataRows['id'];
                $eName = $dataRows['enam'];
                $SSN = $dataRows['ssn'];
                $Dept = $dataRows['dept'];
                $Salary = $dataRows['salary'];
                $homeAdd = $dataRows['homeaddress'];
    ?>
    <table class="table table-danger table-striped border">
        <thead class="thead-light text-center">View from Database</thead>
        <tbody>
        <tr>
            <th>ID</th>
            <th>Employee Name</th>
            <th>SSN</th>
            <th>Department</th>
            <th>Salary</th>
            <th>Home Address</th>
            <th>New</th>
        </tr>
        <tr>
            <td><?php echo $ID; ?></td>
            <td><?php echo $eName; ?></td>
            <td><?php echo $SSN; ?></td>
            <td><?php echo $Dept; ?></td>
            <td><?php echo $Salary; ?></td>
            <td><?php echo $homeAdd; ?></td>
            <td><a href="SearchFromDatabase.php">Search Again</a></td>
        </tr>
        </tbody>
    </table>
        <?php
        }
    }
        ?>



    <!--for success Deleted record message that redirect to this page -->
    <!--@ before $_GET means OK if 'Deleted' wasn't in url -->
    <h2 class="font-weight-bold text-info"><?php echo @$_GET['Deleted'] ?></h2>
    <h2 class="font-weight-bold text-info"><?php echo @$_GET['Updated'] ?></h2>
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
            <td><a href="Update.php?Update=<?php echo $ID; ?>">Update</a></td>
            <td><a href="Delete.php?Delete=<?php echo $ID; ?>">Delete</a></td>
        </tr>
        </tbody>

        <?php } ?>
    </table>
</div>
</body>
</html>