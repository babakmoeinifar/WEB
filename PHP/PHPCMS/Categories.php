<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmLogin();//for disallowing to enter site without username and password?>
<?php
if(isset($_POST["Submit"])){
    $category=$_POST["Category"];
    date_default_timezone_set("Asia/Tehran");
    $currentTime=time();
    $dateTime=strftime("%Y-%B-%d %H:%M:%S",$currentTime);
    $dateTime;
    $admin = $_SESSION['Username'];
    if(empty($category)){
        $_SESSION["ErrorMessage"]="All Fields must be filled out";
        redirectTo("Categories.php");

    }elseif(strlen($category)>99){
        $_SESSION["ErrorMessage"]="Too long Name for Category";
        redirectTo("Categories.php");

    }else{
        global $connection;
        $query="INSERT INTO category(datetime,name,creatorname)
	            VALUES('$dateTime','$category','$admin')";
        $Execute=mysqli_query($connection,$query);
        if($Execute){
            $_SESSION["SuccessMessage"]="Category Added Successfully";
            redirectTo("Categories.php");
        }else{
            $_SESSION["ErrorMessage"]="Category failed to Add";
            redirectTo("Categories.php");

        }

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories</title>
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
                <li class="active"><a class="nav-link" href="Categories.php">
                        <span class="pl-2 glyphicon glyphicon-tags">&nbsp;</span>Categories</a></li>
                <li><a class="nav-link" href="Admins.php">
                        <span class="pl-2 glyphicon glyphicon-user">&nbsp;</span>Manage Admins</a></li>
                <li><a class="nav-link" href="Comments.php">
                        <span class="pl-2 glyphicon glyphicon-comment">&nbsp;</span>Comments<?php //Show badge counter of UnApproved comments
                        global $connection;
                        $queryTotal = "SELECT COUNT(*) FROM comments WHERE status='off'";
                        $executeTotal = mysqli_query($connection, $queryTotal);
                        $rowsTotal = mysqli_fetch_array($executeTotal);
                        $totalTotal = array_shift($rowsTotal); //make array as a ONE unit
                        if (($totalTotal) > 0){
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
            <h1>Manage Categories</h1>
            <?php echo errorMessage();?>
            <?php echo successMessage(); ?>
            <!-- block php for reporting that Add New Category is success or failed -->
            <div>
                <form action="Categories.php" method="POST">
                    <fieldset>
                        <div class="form-group">
                        <label class="form-label" for="categoryname"><span class='text-info'>Name:</span></label>
                        <input class="form-control" type="text" name="Category" id="categoryname"
                               placeholder="Name"><br>
                        <input class="btn btn-success btn-block" type="Submit" name="Submit"
                               value="Add New Category"><br>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Sr No.</th>
                        <th>Date & Time</th>
                        <th>Category Name</th>
                        <th>Creator Name</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    global $connection;
                    $viewQuery = "SELECT * FROM category ORDER BY id desc";
                    $execute = mysqli_query($connection, $viewQuery);
                    $srNo = 0; //set id by default 0
                    while ($dataRows = mysqli_fetch_array($execute)){
                    $id = $dataRows["id"];
                    $dateTime = $dataRows["datetime"];
                    $categoryName = $dataRows["name"];
                    $creatorName = $dataRows["creatorname"];
                    $srNo++; //increment id
                    ?>
                    <tr>
                        <td><?php echo $id ?></td>
                        <td><?php echo $dateTime ?></td>
                        <td><?php echo $categoryName ?></td>
                        <td><?php echo $creatorName ?></td>
                        <td><a href="DeleteCategory.php?id=<?php echo $id ;?>">
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