<!-- 02 LEARN -->
<?php
if (isset($_POST['submit'])){
    if (!empty($_POST['eName'])&&
        !empty($_POST['SSN'])&&
        !empty($_POST['Dept'])&&
        !empty($_POST['Salary'])&&
        !empty($_POST['homeAddress'])) {
        $connection = mysqli_connect('localhost', 'root', '', 'record');
        $eName = mysqli_real_escape_string($connection,$_POST['eName']);
        $ssn = mysqli_real_escape_string($connection,$_POST['SSN']);
        $dept = mysqli_real_escape_string($connection,$_POST['Dept']);
        $salary = mysqli_real_escape_string($connection,$_POST['Salary']);
        $homeAdd = mysqli_real_escape_string($connection,$_POST['homeAddress']);


        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        //INSERT record into TABLE
        //emp_record is table that created in database
        //in () variables are our columns that created in database
        $query = "INSERT INTO emp_record (`enam`, `ssn`, `dept`, `salary`, `homeaddress`) 
              VALUES ('$eName','$ssn','$dept','$salary','$homeAdd')";
        $execute = mysqli_query($connection, $query);
        if (!$execute) {
            die("SQL Error: " . mysqli_error($connection));
        } else {
            echo "<span class='text-info font-weight-bold'>Record has been added.</span>";
        }


    }else{
        echo "<span class='text-danger font-weight-bold'>Please add all information...</span>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Insert into Database</title>
</head>
<body>
<div class="container mt-5">
    <form class="form-group bg-light p-3" action="InsertIntoDatabase.php" method="post">
        <fieldset class="form-group">

            Employee Name: <br>
            <input class="form-control" type="text" name="eName" value=""><br>
            Social Security Number: <br>
            <input class="form-control" type="text" name="SSN" value=""><br>
            Department: <br>
            <input class="form-control" type="text" name="Dept" value=""><br>
            Salary: <br>
            <input class="form-control" type="text" name="Salary" value=""><br>
            Home Address: <br>
            <textarea class="form-control" type="text" name="homeAddress" value=""></textarea><br>
            <input class="btn btn-danger" type="submit" name="submit" value="Submit your record">
        </fieldset>


    </form>
</div>
</body>
</html>