<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php confirmLogin();//for disallowing to enter site without username and password?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments</title>
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="maps/glyphicons-fontawesome.min.css">
    <link rel="stylesheet" href="style/adminstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>


<div class="container-fluid"> <!-- Side area -->
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
                <li><a class="nav-link" href="Admins.php">
                        <span class="pl-2 glyphicon glyphicon-user">&nbsp;</span>Manage Admins</a></li>
                <li class="active"><a class="nav-link" href="Comments.php">
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
            <?php echo errorMessage(); ?>
            <?php echo successMessage(); ?>
            <div>
                <!-- Table of UnApproved Comments -->
                <h1>Un-Approved Comments</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete Comment</th>
                            <th>Details</th>
                        </tr>
                        <?php
                        global $connection;
                        $query = "SELECT * FROM comments WHERE status='off' ORDER BY datetime DESC";
                        $execute = mysqli_query($connection, $query);
                        $srNo = 0;
                        while ($DataRows = mysqli_fetch_array($execute)) {
                            $CommentId = $DataRows['id'];
                            $DateTimeofComment = $DataRows['datetime'];
                            $PersonName = $DataRows['name'];
                            $PersonComment = $DataRows['comment'];
                            //$ApprovedBy = $DataRows['approvedby'];
                            $CommentedPostId = $DataRows['admin_panel_id'];
                            $srNo++;
                            if (strlen($PersonName) > 10) {
                                $PersonName = substr($PersonName, 0, 10) . '..';
                            }
                            if (strlen($DateTimeofComment) > 18) {
                                $DateTimeofComment = substr($DateTimeofComment, 0, 18);
                            }
                            ?>

                            <tr>
                                <td><?php echo htmlentities($srNo); ?></td>
                                <td style="color: #5e5eff;"><?php echo $PersonName; ?></td>
                                <td><?php echo htmlentities($DateTimeofComment); ?></td>
                                <td><?php echo nl2br($PersonComment); ?></td>
                                <td><a href="ApproveComments.php?id=<?php echo $CommentId; ?>">
                                        <span class="btn btn-success">Approve</span></a></td>
                                <td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>">
                                        <span class="btn btn-danger">Delete</span></a></td>
                                <td><a href="FullPost.php?id=<?php echo $CommentedPostId; ?>" target="_blank">
                                        <span class="btn btn-primary">Live Preview</span></a></td>
                            </tr>
                        <?php } ?>


                    </table>
                </div><!-- Ending Table of UnApproved Comments -->
                <hr>
                <!-- Table of Approved Comments -->
                <h1>Approved Comments</h1>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Comment</th>
                            <th>Approved By</th>
                            <th>Revert Approval</th>
                            <th>Delete Comment</th>
                            <th>Details</th>
                        </tr>
                        <?php
                        global $connection;
                        $query = "SELECT * FROM comments WHERE status='on' ORDER BY datetime DESC";
                        $execute = mysqli_query($connection, $query);
                        $srNo = 0;
                        while ($DataRows = mysqli_fetch_array($execute)) {
                            $CommentId = $DataRows['id'];
                            $DateTimeofComment = $DataRows['datetime'];
                            $PersonName = $DataRows['name'];
                            $PersonComment = $DataRows['comment'];
                            $ApprovedBy = $DataRows['approvedby'];
                            $CommentedPostId = $DataRows['admin_panel_id'];
                            $srNo++;
                            if (strlen($PersonName) > 10) {
                                $PersonName = substr($PersonName, 0, 10) . '..';
                            }
                            if (strlen($DateTimeofComment) > 18) {
                                $DateTimeofComment = substr($DateTimeofComment, 0, 18);
                            }
                            ?>

                            <tr>
                                <td><?php echo htmlentities($srNo); ?></td>
                                <td style="color: #5e5eff;"><?php echo $PersonName; ?></td>
                                <td><?php echo htmlentities($DateTimeofComment); ?></td>
                                <td><?php echo htmlentities($PersonComment); ?></td>
                                <td><span><?php echo $ApprovedBy;?></span></td>
                                <td><a href="DisApproveComments.php?id=<?php echo $CommentId; ?>">
                                        <span class="btn btn-warning">Dis-Approve</span></a></td>
                                <td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>">
                                        <span class="btn btn-danger">Delete</span></a></td>
                                <td><a href="FullPost.php?id=<?php echo $CommentedPostId; ?>" target="_blank">
                                        <span class="btn btn-primary">Live Preview</span></a></td>
                            </tr>
                        <?php } ?>


                    </table>
                </div><!-- Ending Table of Approved Comments -->


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