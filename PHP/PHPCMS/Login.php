<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
    $userName = $_POST["Username"];
    $password = $_POST["Password"];


    if (empty($userName) || empty($password)) {
        $_SESSION["ErrorMessage"] = "All Fields must be filled out";
        redirectTo("Login.php");

    }  else {
        $foundAccount = loginAttempt($userName,$password);
        $_SESSION['User_Id'] = $foundAccount['id'];
        $_SESSION['Username'] = $foundAccount['username'];
        if ($foundAccount){
            $_SESSION["SuccessMessage"] = "Welcome! ".$_SESSION['Username'];
            redirectTo("dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = 'Invalid Username / Password';
            redirectTo("Login.php");
        }

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log-in</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="maps/glyphicons-fontawesome.min.css">
    <link rel="stylesheet" href="style/adminstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body style="background-color: white">
<div class="bg-info" style="height: 10px;"></div>
<nav class="navbar navbar-expand-md bg-dark navbar-dark" role="navigation">
    <!-- Brand -->
    <a class="navbar-brand mr-0" href="Blog.php">
        <img src="images/logo.png" alt="logo" width="200" ; height="30" ;>
    </a>
    <div class="container">
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapse">
        </div><!-- collapse -->
    </div><!-- nav container -->
</nav><!-- nav -->
<div class="bg-info" style="height: 10px;"></div>
<!-- End of Navigation bar -->


<div class="col-sm-4 offset-4 mt-5">

    <?php echo errorMessage(); ?>
    <?php echo successMessage(); ?>
    <h2>Welcome back!</h2>

    <!-- block php for reporting that Add New Category is success or failed -->
    <div>
        <form action="Login.php" method="POST">
            <fieldset>
                <div class="form-group">
                    <label class="form-label" for="username"><span class='text-info'>Username:</span></label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text rounded-0 border-right-0">
                            <span class="glyphicon glyphicon-envelope text-primary"></span>
                        </span>
                    <input class="form-control" type="text" name="Username" id="username" placeholder="Username"><br>
                    </div>
                    <div class="form-group mt-2">
                    <label class="form-label" for="Password"><span class='text-info'>Password:</span></label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text rounded-0 border-right-0">
                            <span class="glyphicon glyphicon-lock text-primary"></span>
                        </span>
                    <input class="form-control" type="password" name="Password" id="Password"
                           placeholder="Password"><br>
                    </div>
                    <input class="btn btn-info btn-block mt-4 btn-lg" type="Submit" name="Submit"
                           value="Login"><br>
                </div>
            </fieldset>
        </form>
    </div>

</div> <!--Ending of Main area-->
</div> <!--Ending of row-->
</div> <!--Ending of Container-->

</body>
</html>