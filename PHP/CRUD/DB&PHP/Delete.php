<!-- 05 LEARN -->
<?php
$connection = mysqli_connect('localhost', 'root', '', 'record');
$deleteRecordId = $_GET['Delete']; //Delete is that one that in the href of <a>
$deleteQuery = "DELETE FROM emp_record WHERE id='$deleteRecordId'";
$execute = mysqli_query($connection,$deleteQuery);

if ($execute){
    //return to page if succeed
    echo "<script>window.open('UpdateIntoDatabase.php?Deleted= رکورد با موفقیت حذف شد','_self')</script>";
}else{
    echo 'خطایی رخ داده است';
}






?>