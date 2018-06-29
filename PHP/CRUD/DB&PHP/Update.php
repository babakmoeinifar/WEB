<!-- 07 LEARN -->
<?php
$connection = mysqli_connect('localhost', 'root', '', 'record');
$updateRecord = $_GET['Update']; //'Update' comes from <a href="   " of UpdateInfoDatabase.php table
$showQuery = "SELECT * FROM emp_record WHERE id='$updateRecord'";
$update = mysqli_query($connection, $showQuery);

while ($dataRows = mysqli_fetch_array($update)) {
    $updateId = $dataRows['id']; //catch id from sql TABLE and put it in $updateId
    $eName = $dataRows['enam'];
    $SSN = $dataRows['ssn'];
    $Dept = $dataRows['dept'];
    $Salary = $dataRows['salary'];
    $homeAdd = $dataRows['homeaddress'];
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap.min.css">
        <title>Update .php</title>
    </head>
    <body>
    <div class="container mt-5">
        <form class="form-group bg-light p-3" action="Update.php?updateId=<?php echo $updateId; ?>" method="post">
            <fieldset class="form-group">

                Employee Name: <br>
                <input class="form-control" type="text" name="eName" value="<?php echo $eName; ?>"><br>
                Social Security Number: <br>
                <input class="form-control" type="text" name="SSN" value="<?php echo $SSN; ?>"><br>
                Department: <br>
                <input class="form-control" type="text" name="Dept" value="<?php echo $Dept; ?>"><br>
                Salary: <br>
                <input class="form-control" type="text" name="Salary" value="<?php echo $Salary; ?>"><br>
                Home Address: <br>
                <textarea class="form-control" type="text" name="homeAddress"><?php echo $homeAdd; ?></textarea><br>
                <input class="btn btn-danger" type="submit" name="submit" value="Update record">
            </fieldset>
        </form>
    </div>
    </body>
    </html>
<?php
//This code block is for Editing the Data that got in your form (means Update record)
$connection = mysqli_connect('localhost', 'root', '', 'record');
if (isset($_POST['submit'])) {
    $updateId = $_GET['updateId']; //This 'updateId' comes from our where loop on line 8 ($updateId)
    $eName = $_POST['eName'];
    $SSN = $_POST['SSN'];
    $Dept = $_POST['Dept'];
    $homeAdd = $_POST['homeAddress'];

    $updateQuery = "UPDATE emp_record SET enam='$eName',ssn='$SSN',dept='$Dept',salary='$Salary',homeaddress='$homeAdd'
                    WHERE id = '$updateId'";
    $execute = mysqli_query($connection, $updateQuery);
    if ($execute) {
        function redirectTo($newLocation)
        {
            header("Location:" . $newLocation);
            exit;
        }

        //this function is other way of this script:
        //echo "<script>window.open('DeleteFromDatabase.php?Deleted= رکورد با موفقیت حذف شد','_self')</script>";
        redirectTo("UpdateIntoDatabase.php?Updated=رکورد با موفقیت ویرایش شد");
    } else {
        echo "خطایی رخ داده";
    }
}
?>