<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php
function redirectTo($newLocation){
    //redirect to url
    header("Location:".$newLocation);
    exit;
}
//check username and password are correct
function loginAttempt($userName,$password){
    global $connection;
    $query = "SELECT * FROM registration 
              WHERE username='$userName' AND password='$password'";
    $execute = mysqli_query($connection,$query);
    if ($admin = mysqli_fetch_assoc($execute)){
        return $admin;
    }else{
        return null;
    }
}
//check username and password id's is set or not
function loginFunc(){
    if (isset($_SESSION['User_Id'])){
        return true;
    }
}
//for disallowing to enter site without username and password
function confirmLogin(){
    if (!loginFunc()){
        $_SESSION["ErrorMessage"] = 'Login Required !';
        redirectTo('Login.php');
    }
}
?>