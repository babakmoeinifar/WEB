<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmLogin();//for disallowing to enter site without username and password?>
<?php
if (isset($_POST["Submit"])) {
    $userName = $_POST["Username"];
    $password = $_POST["Password"];
    $confirmPassword = $_POST["ConfirmPassword"];
    date_default_timezone_set("Asia/Tehran");
    $currentTime = time();
    $dateTime = strftime("%Y-%B-%d %H:%M:%S", $currentTime);
    $dateTime;
    $admin = $_SESSION['Username']; //Catch from $userName from DB
    if (empty($userName) || empty($password) || empty($confirmPassword)) {
        $_SESSION["ErrorMessage"] = "All Fields must be filled out";
        redirectTo("Admins.php");

    } elseif (strlen($password) < 6) {
        $_SESSION["ErrorMessage"] = "At least 6 characters for password";
        redirectTo("Admins.php");

    }elseif ($password !== $confirmPassword) {
        $_SESSION["ErrorMessage"] = "Password / ConfirmPassword doesn't match";
        redirectTo("Admins.php");

    } else {
        global $connection;
        $query = "INSERT INTO registration(datetime,username,password,addedby)
	            VALUES('$dateTime','$userName','$password','$admin')";
        $Execute = mysqli_query($connection, $query);
        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Admin Added Successfully";
            redirectTo("Admins.php");
        } else {
            $_SESSION["ErrorMessage"] = "Admin failed to Add";
            redirectTo("Admins.php");

        }

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="maps/glyphicons-fontawesome.min.css">
    <link rel="stylesheet" href="style/adminstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <br><br>
            <ul class="nav navbar-nav nav-pills pl-2" id="sideMenu">
                <li><a class="nav-link" href="dashboard.php">
                        <span class="pl-2 glyphicon glyphicon-th">&nbsp;</span>Dashboard</a></li>
                <li><a class="nav-link" href="AddNewPost.php">
                        <span class="pl-2 glyphicon glyphicon-list-alt">&nbsp;</span>Add new post</a></li>
                <li><a class="nav-link" href="Categories.php">
                        <span class="pl-2 glyphicon glyphicon-tags">&nbsp;</span>Categories</a></li>
                <li class="active"><a class="nav-link" href="Admins.php">
                        <span class="pl-2 glyphicon glyphicon-user">&nbsp;</span>Manage Admins</a></li>
                <li><a class="nav-link" href="Comments.php">
                        <span class="pl-2 glyphicon glyphicon-comment">&nbsp;</span>Comments<?php //Show badge counter of UnApproved comments
                        global $connection;
                        $queryTotal = "SELECT COUNT(*) FROM comments WHERE status='off'";
                        $executeTotal = mysqli_query($connection, $queryTotal);
                        $rowsTotal = mysqli_fetch_array($executeTotal);
                        $totalTotal = array_shift($rowsTotal); //make array as a ONE unit
                        if (($totalTotal) > 0) {
                            ?>
                            <span class="float-right badge badge-warning mt-1 mr-2">
                            <?php echo $totalTotal;//total of UnApproved comments
                            ?>
                        </span><!-- Ending of showing Total badge counter -->
                        <?php } ?></a></li>
                <li><a class="nav-link" href="Blog.php?Page=1" target="_blank">
                        <span class="pl-2 glyphicon glyphicon-equalizer">&nbsp;</span>Live Blog</a></li>
                <li><a class="nav-link" href="LogOut.php">
                        <span class="pl-2 glyphicon glyphicon-warning-sign">&nbsp;</span>Logout</a></li>
            </ul>


        </div> <!--ending of side area-->

        <div class="col-sm-10">
            <h1>Manage Admin Access</h1>
            <?php echo errorMessage(); ?>
            <?php echo successMessage(); ?>
            <!-- block php for reporting that Add New Category is success or failed -->
            <div>
                <form action="Admins.php" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <label class="form-label" for="username"><span class='text-info'>Username:</span></label>
                            <input class="form-control" type="text" name="Username" id="username"
                                   placeholder="Username"><br>
                            <label class="form-label" for="Password"><span
                                        class='text-info'>Password:</span></label>
                            <input class="form-control" type="password" name="Password" id="Password"
                                   placeholder="Password"><br>
                            <label class="form-label" for="ConfirmPassword"><span
                                        class='text-info'>Confirm Password:</span></label>
                            <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword"
                                   placeholder="Retype same password"><br>
                            <input class="btn btn-success btn-block" type="Submit" name="Submit"
                                   value="Add New Admin"><br>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Sr No.</th>
                        <th>Date & Time</th>
                        <th>Admin Name</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    global $connection;
                    $viewQuery = "SELECT * FROM registration ORDER BY id desc";
                    $execute = mysqli_query($connection, $viewQuery);
                    $srNo = 0; //set id by default 0
                    while ($dataRows = mysqli_fetch_array($execute)){
                    $id = $dataRows["id"];
                    $dateTime = $dataRows["datetime"];
                    $userName = $dataRows["username"];
                    $admin = $dataRows["addedby"];
                    $srNo++; //increment id
                    ?>
                    <tr>
                        <td><?php echo $id ?></td>
                        <td><?php echo $dateTime ?></td>
                        <td><?php echo $userName ?></td>
                        <td><?php echo $admin ?></td>
                        <td><a href="DeleteAdmin.php?id=<?php echo $id; ?>">
                                <span class="btn btn-danger">Delete</span></a></td>
                    </tr>
                    <?php } ?><!--end of while-->
                </table>
            </div>

        </div> <!--Ending of Main area-->
    </div> <!--Ending of row-->
</div> <!--Ending of Container-->
<div class="text-light font-weight-bold p-2 border-top bg-dark text-center" id="footer">
    <hr>
    <p>Theme By | Babak Moeinifar | &copy;2018 --- All right reserved.</p>
    <p>This is site for testing PHP CMS</p>
    <hr>
</div>
<div class="bg-info" style="height: 10px">
</div>
</body>
</html>