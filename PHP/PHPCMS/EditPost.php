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
        //Updating datas from database
        global $connection;
        $editFromURL = $_GET['Edit'];
        $query = "UPDATE admin_panel SET datetime='$dateTime', title='$title',
                    category='$category', author='$aAdmin',image='$image',post='$post'
                    WHERE id='$editFromURL'";
        $execute = mysqli_query($connection, $query);
        //Move the image that uploaded by client to upload folder for accessing DB
        move_uploaded_file($_FILES['Image']['tmp_name'], $target);
        //Success Messages
        if ($execute) {
            $_SESSION["SuccessMessage"] = 'Post Updated Successfully';
            redirectTo("dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = 'Post failed to Update';
            redirectTo("dashboard.php");
        }

    }

}//End of if(isset($_POST["Submit"]

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
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
                        <span class="pl-2 glyphicon glyphicon-comment">&nbsp;</span>Comments</a></li>
                <li><a class="nav-link" href="Blog.php?Page=1" target="_blank">
                        <span class="pl-2 glyphicon glyphicon-equalizer">&nbsp;</span>Live Blog</a></li>
                <li><a class="nav-link" href="LogOut.php">
                        <span class="pl-2 glyphicon glyphicon-warning-sign">&nbsp;</span>Logout</a></li>
            </ul>


        </div> <!--ending of side area-->

        <div class="col-sm-10">
            <h1>Update Post</h1>
            <!-- block php for reporting that Update Category is success or failed -->
            <?php echo errorMessage(); ?>
            <?php successMessage(); ?>

            <div><!--  -->
                <?php
                //Read records from DB and put them in to the variables
                $searchQueryParameter = $_GET['Edit'];
                global $connection;
                $query = "SELECT * FROM admin_panel WHERE id='$searchQueryParameter'";
                $executeQuery = mysqli_query($connection, $query);
                while ($dataRows = mysqli_fetch_array($executeQuery)) {
                    $titleToUpdate = $dataRows['title'];
                    $categoryToUpdate = $dataRows['category'];
                    $imageToUpdate = $dataRows['image'];
                    $postToUpdate = $dataRows['post'];
                }
                ?>

                <!-- enctype="multipart/form-data" is for using image in form -->
                <form class="form-group" action="EditPost.php?Edit=<?php echo $searchQueryParameter; ?>" method="POST"
                      enctype="multipart/form-data">
                    <fieldset>
                        <label class="form-label" for="title"><span class='text-info'>Title:</span></label>
                        <input class="form-control" type="text" name="Title" id="title"
                               placeholder="Title" value="<?php echo $titleToUpdate; ?>"><br>
                        <!-- Existing Category -->
                        <span class="text-info">Existing Category:</span>
                        <?php echo $categoryToUpdate; ?><br>
                        <label class="form-label" for="categoryselect"><span
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
                        </select><br>

                        <!-- Existing Image -->
                        <span class="text-info">Existing Image:</span>
                        <img class="rounded" src="Upload/<?php echo $imageToUpdate; ?>" width="50" height="50"><br>
                        <!--Image file Update btn -->
                        <label class="form-label" for="imageselect"><span
                                    class='text-info'>Select image:</span></label>
                        <input class="form-control btn" type="file" name="Image" id="imageselect">
                        <!--Post Update -->
                        <label class="form-label pt-3" for="postarea"><span class="text-info">Post:</span></label>
                        <textarea name="Post" id="postarea" class="form-control">
                            <?php echo $postToUpdate; ?>
                        </textarea>
                        <!-- Update Post btn -->
                        <br><input class="btn btn-success btn-block" type="Submit" name="Submit"
                                   value="Update Post"><br>
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