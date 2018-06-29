<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmLogin();//for disallowing to enter site without username and password?>

<?php
if (isset($_GET['id'])){
    $idFromURL = $_GET['id'];
    global $connection;
    $query = "DELETE FROM registration WHERE id='$idFromURL'";
    $execute = mysqli_query($connection,$query);
    $_SESSION["SuccessMessage"]="Admin Removed Successfully";
    redirectTo("Admins.php");
}else{
    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
    redirectTo("Admins.php");

}

?>