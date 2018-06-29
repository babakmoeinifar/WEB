<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmLogin();//for disallowing to enter site without username and password?>
<?php
if (isset($_GET['id'])){
    $idFromURL = $_GET['id'];
    global $connection;
    $query = "UPDATE comments SET status='off' WHERE id='$idFromURL'";
    $execute = mysqli_query($connection,$query);
    $_SESSION["SuccessMessage"]="Comment DisApproved Successfully";
    redirectTo("Comments.php");
}else{
    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
    redirectTo("Comments.php");
}

?>