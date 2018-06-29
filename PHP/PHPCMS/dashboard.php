<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmLogin();//for disallowing to enter site without username and password?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="maps/glyphicons-fontawesome.min.css">
    <link rel="stylesheet" href="style/adminstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
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
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link text-light" href="#">Home</a></li>
                <li class="nav-item active"><a class="nav-link text-light" href="Blog.php" target="_blank">Blog</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#">AboutUs</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#">ContactUs</a></li>
                <li class="nav-item mr-1"><a class="nav-link text-light" href="#">Features</a></li>
            </ul>
            <!--Search-->
            <form action="Blog.php" class="form-inline">
                <div class="form-inline">
                    <input type="text" class="form-control mr-2" name="Search" placeholder="Search">
                    <button class="btn btn-outline-light" name="SearchButton">Go</button>
                </div><!-- search input -->
            </form>
        </div><!-- collapse -->
    </div><!-- nav container -->
</nav><!-- nav -->
<div class="bg-info" style="height: 10px;"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <br><br>
            <ul class="nav navbar-nav nav-pills pl-2" id="sideMenu">
                <li class="active"><a class="nav-link" href="dashboard.php">
                        <span class="pl-2 glyphicon glyphicon-th">&nbsp;</span>Dashboard</a></li>
                <li><a class="nav-link" href="AddNewPost.php">
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

        <div class="col-sm-10"> <!-- Main Area -->
            <?php echo errorMessage();
            echo successMessage();
            ?>
            <h1>Admin Dashboard</h1>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <tr>
                        <th>No</th>
                        <th>Post Title</th>
                        <th>Date Time</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                    <?php
                    global $connection;
                    $viewQuery = "SELECT * FROM admin_panel ORDER BY id desc;";
                    $execute = mysqli_query($connection, $viewQuery);
                    $srNo = 0;
                    while ($dataRows = mysqli_fetch_array($execute)) {
                        $id = $dataRows['id'];
                        $dateTime = $dataRows['datetime'];
                        $title = $dataRows['title'];
                        $category = $dataRows['category'];
                        $admin = $dataRows['author'];
                        $image = $dataRows['image'];
                        $post = $dataRows['post'];
                        $srNo++;
                        ?>
                        <tr>
                            <td><?php echo $srNo; ?></td>
                            <td class="text-info"><?php
                                //limit $title length
                                if (strlen($title) > 22) {
                                    $title = substr($title, 0, 22) . '..';
                                }
                                echo $title; ?>
                            </td>
                            <td><?php
                                if (strlen($dateTime) > 12) {
                                    $dateTime = substr($dateTime, 0, 12) . '..';
                                }
                                echo $dateTime; ?>
                            </td>
                            <td><?php
                                if (strlen($admin) > 5) {
                                    $admin = substr($admin, 0, 5) . '..';
                                }
                                echo $admin; ?>
                            </td>
                            <td><?php
                                if (strlen($category) > 8) {
                                    $category = substr($category, 0, 8) . '..';
                                }
                                echo $category; ?>
                            </td>
                            <td><img src="upload/<?php echo $image; ?>" width="80px" ; height="50px" ;></td>
                            <td>
                                <?php //Show badge counter of UnApproved comments
                                global $connection;
                                $queryUnApproved = "SELECT COUNT(*) FROM comments 
                                                      WHERE admin_panel_id ='$id' AND status='off'";
                                $executeUnApproved = mysqli_query($connection, $queryUnApproved);
                                $rowsUnApproved = mysqli_fetch_array($executeUnApproved);
                                $totalUnApproved = array_shift($rowsUnApproved); //make array as a ONE unit
                                if (($totalUnApproved) > 0) {
                                    ?>
                                    <span class="float-left badge badge-danger">
                                        <?php echo $totalUnApproved;//total of Approved comments
                                        ?>
                                    </span><!-- Ending of showing UnApproved badge counter -->
                                <?php } ?>
                                <?php //Show badge counter of Approved comments
                                global $connection;
                                $queryApproved = "SELECT COUNT(*) FROM comments 
                                                      WHERE admin_panel_id ='$id' AND status='on'";
                                $executeApproved = mysqli_query($connection, $queryApproved);
                                $rowsApproved = mysqli_fetch_array($executeApproved);
                                $totalApproved = array_shift($rowsApproved); //make array as a ONE unit
                                if (($totalApproved) > 0){
                                ?>
                                <span class="float-right badge badge-success"><?php echo $totalApproved;//total of Approved comments
                                    ?>
                                    </span>
                                <?php } ?><!-- Ending of showing Approved badge counter -->

                            </td>
                            <td><a href="EditPost.php?Edit=<?php echo $id; ?>"><span
                                            class="btn btn-warning">Edit</span></a>
                                <a href="DeletePost.php?Delete=<?php echo $id; ?>"><span
                                            class="btn btn-danger">Delete</span></a>
                            </td>
                            <td><a href="FullPost.php?id=<?php echo $id; ?>" target="_blank"><span
                                            class="btn btn-primary">Live Preview</span></a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div><!--Ending of Table-->
        </div> <!--Ending of Main area-->
    </div> <!--Ending of row-->
    <div class="text-light font-weight-bold p-2 border-top bg-dark text-center" id="footer">
        <hr>
        <p>Theme By | Babak Moeinifar | &copy;2018 --- All right reserved.</p>
        <p>This is site for testing PHP CMS</p>
        <hr>
    </div><!--Ending of footer-->
    <div class="bg-info" style="height: 10px"></div>
</body>
</html>