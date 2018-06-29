<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmLogin();//for disallowing to enter site without username and password?>
<?php
if (isset($_POST["Submit"])) {
    $title = $_POST["Title"];
    $post = $_POST["Post"];
    $category = $_POST["Category"];
    date_default_timezone_set("Asia/Tehran");
    $currentTime = time();
    $dateTime = strftime("%Y-%B-%d %H:%M:%S", $currentTime);
    $dateTime;
    $admin = $_SESSION['Username'];
    //Add image name to DB
    $image = $_FILES['Image']['name'];
    //Add image location to DB
    $target = "upload/" . basename($_FILES['Image']['name']);
    //Error Messages
    if (empty($title)) {
        $_SESSION["ErrorMessage"] = "Title Field must be filled out";
        redirectTo("AddNewPost.php");

    } elseif (strlen($title) < 2) {
        $_SESSION["ErrorMessage"] = "Title should be at least two characters";
        redirectTo("AddNewPost.php");

    } else {
        //Inserting data to database
        global $connection;
        $query = "INSERT INTO admin_panel(datetime,title,category,author,image,post)
	            VALUES('$dateTime','$title','$category','$admin','$image','$post')";
        $execute = mysqli_query($connection, $query);
        //Move the image that uploaded by client to upload folder for accessing DB
        move_uploaded_file($_FILES['Image']['tmp_name'], $target);
        //Success Messages
        if ($execute) {
            $_SESSION["SuccessMessage"] = 'Post Added Successfully';
            redirectTo("AddNewPost.php");
        } else {
            $_SESSION["ErrorMessage"] = 'Post failed to Add';
            redirectTo("AddNewPost.php");
        }

    }

}//End of if(isset($_POST["Submit"]

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Post</title>
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
                <li class="active"><a class="nav-link" href="AddNewPost.php">
                        <span class="pl-2 glyphicon glyphicon-list-alt">&nbsp;</span>Add new post</a></li>
                <li><a class="nav-link" href="Categories.php">
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
            <h1>Add New Post</h1>
            <!-- block php for reporting that Add New Category is success or failed -->
            <?php echo errorMessage(); ?>
            <?php echo successMessage(); ?>

            <div>
                <!-- enctype="multipart/form-data" is for using image in form -->
                <form class="form-group" action="AddNewPost.php" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <label class="form-label" for="title"><span class='text-info'>Title:</span></label>
                        <input class="form-control" type="text" name="Title" id="title"
                               placeholder="Title">
                        <label class="form-label pt-3" for="categoryselect"><span
                                    class='text-info'>Category:</span></label>
                        <!-- php block for selecting category from database -->
                        <select class="form-control" name="Category" id="categoryselect">
                            <?php
                            global $connection;
                            $viewQuery = "SELECT * FROM category ORDER BY id desc";
                            $execute = mysqli_query($connection, $viewQuery);
                            while ($dataRows = mysqli_fetch_array($execute)) {
                                $id = $dataRows["id"];
                                $categoryName = $dataRows["name"];
                                ?>
                                <option><?php echo $categoryName; ?></option>
                            <?php } ?>
                        </select>

                        <label class="form-label pt-3" for="imageselect"><span
                                    class='text-info'>Select image:</span></label>
                        <!--Image file choose btn -->
                        <input class="form-control btn" type="file" name="Image" id="imageselect">
                        <label class="form-label pt-3" for="postarea"><span class="text-info">Post:</span></label>
                        <textarea name="Post" id="postarea" class="form-control"></textarea>
                        <!-- Add new Post btn -->
                        <br><input class="btn btn-success btn-block" type="Submit" name="Submit"
                                   value="Add New Post"><br>
                    </fieldset>
                </form>
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