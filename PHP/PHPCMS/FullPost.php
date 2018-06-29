<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_POST["Submit"])) {
    $name = $_POST["Name"];
    $email = $_POST["Email"];
    $comment = $_POST["Comment"];
    date_default_timezone_set("Asia/Tehran");
    $currentTime = time();
    $dateTime = strftime("%Y-%B-%d %H:%M:%S", $currentTime);
    $dateTime;
    $postId = $_GET['id'];
    //Error Messages
    if (empty($name) || empty($email) || empty($comment)) {
        $_SESSION["ErrorMessage"] = "All Fields must be filled out";

    } elseif (strlen($comment) > 500) {
        $_SESSION["ErrorMessage"] = "Comment should be less than 500 characters";

    } else {
        //Inserting data to database
        global $connection;
        $postIdFromURL = $_GET['id']; //getting url id of post for foreign key->admin_panel_id
        $query = "INSERT into comments (datetime,name,email,comment,approvedby,status,admin_panel_id)
	            VALUES ('$dateTime','$name','$email','$comment','Pending','OFF','$postIdFromURL')";
        $execute = mysqli_query($connection, $query);
        //Success Messages
        if ($execute) {
            $_SESSION["SuccessMessage"] = 'Comment Submitted Successfully';
            redirectTo("FullPost.php?id={$postId}");
        } else {
            $_SESSION["ErrorMessage"] = 'Comment failed to submit';
            redirectTo("FullPost.php?id={$postId}");
        }

    }

}//End of if(isset($_POST["Submit"]
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="maps/glyphicons-fontawesome.min.css">
    <link rel="stylesheet" href="style/publicstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Full Blog Post</title>
</head>
<body>
<div class="bg-info" style="height: 10px;"></div>
<nav class="navbar navbar-expand-md bg-dark navbar-dark" role="navigation">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="Blog.php">
            <img src="images/logo.png" alt="logo" width="200" ; height="30" ;>
        </a>
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-light" href="#">Home</a></li>
                <li class="nav-item active"><a class="nav-link text-light" href="Blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#">AboutUs</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#">ContactUs</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="#">Features</a></li>
            </ul>
            <!--Search-->
            <form action="Blog.php" class="form-inline">
                <div class="form-inline">
                    <input type="text" class="form-control mr-2" name="Search" placeholder="Search">
                </div><!-- search input -->
                <button class="btn btn-outline-light" name="SearchButton">Go</button>
            </form>
        </div><!-- collapse -->
    </div><!-- nav container -->
</nav><!-- nav -->
<div class="bg-info" style="height: 10px;"></div>
<!-- End of Navigation bar -->

<div class="container">
    <div class="blog-header">
        <h1>The complete responsive CMS blog</h1>
        <p class="lead">The complete blog using PHP by Babak Moeinifar</p>
    </div>
    <div class="row">
        <div class="col-sm-8"> <!-- Main Blog Area -->
            <!-- block php for reporting that Adding Comment is success or failed -->
            <?php echo errorMessage(); ?>
            <?php echo successMessage(); ?>
            <?php
            global $connection;
            //Search Button code block
            if (isset($_GET['SearchButton'])) {
                $search = $_GET['Search'];
                $viewQuery = "SELECT * FROM admin_panel 
                              WHERE datetime LIKE '%$search%' 
                              OR title LIKE '%$search%' 
                              OR category LIKE '%$search%' 
                              OR post LIKE '%$search%'";
            } else {
                $postIdFromURL = $_GET['id']; //for showing full post > 150 characters
                //else didn't search by client and show full post after search
                $viewQuery = "SELECT * FROM admin_panel WHERE id='$postIdFromURL' 
                              ORDER BY datetime desc";
            }
            $execute = mysqli_query($connection, $viewQuery);
            while ($dataRows = mysqli_fetch_array($execute)) {
                $postId = $dataRows['id'];
                $dateTime = $dataRows['datetime'];
                $title = $dataRows['title'];
                $category = $dataRows['category'];
                $admin = $dataRows['author'];
                $image = $dataRows['image'];
                $post = $dataRows['post'];
                ?>
                <div class="img-thumbnail blogpost text-center">
                    <img class="rounded img-fluid" src="upload/<?php echo $image; ?>">
                    <div class="figure-caption text-left">
                        <h2 id="heading"><?php echo htmlentities($title); ?></h2>
                        <p id="catpost" class="text-info">Category:<?php echo htmlentities($category); ?><br>
                            Published on: <?php echo htmlentities($dateTime); ?></p>
                        <p id="postentities"><?php
                            echo nl2br($post);//nl2br is for correcting Pargraph and nextLine ?></p>
                    </div>
                </div>
            <?php } ?>

            <br>
            <div class="bg-light rounded p-2"><!-- Comments -->

            <span class="text-info font-weight-bold">Comments</span>
                <hr>

            <span class="text-info font-weight-bold">Share your thoughts about this post:</span>

            <?php
            global $connection;
            $postIdForComments = $_GET['id'];
            $extractingCommentsQuery = "SELECT * FROM comments 
                                        WHERE admin_panel_id='$postIdForComments' AND status='on'";
            $execute = mysqli_query($connection,$extractingCommentsQuery);
            while ($dataRows = mysqli_fetch_array($execute)){
                $commentDate=$dataRows["datetime"];
                $commenterName=$dataRows["name"];
                $comments=$dataRows["comment"];
                ?>
                <div class="CommentBlock p-1" style="background-color: #f0f1f3">
                    <img style="margin-left: 10px; margin-top: 10px;" class="float-left" src="images/comment.png" width=70px; height=70px;>
                    <p style="margin-left: 90px;" class="text-info font-weight-bold"><?php echo $commenterName; ?></p>
                    <p style="margin-left: 90px;"class="description text-info"><?php echo $commentDate; ?></p>
                    <p style="margin-left: 90px; margin-top: -2px; font-size: 1.1em;" class="border border-light p-1 "><?php echo nl2br($comments); ?></p>

                </div>

                <hr>
            <?php } ?>
            </div><!-- Ending Comments -->
            <div>
                <!-- enctype="multipart/form-data" is for using image in form -->
                <form class="form-group border border-light p-2 bg-light rounded" action="FullPost.php?id=<?php echo $postId;?>" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <!-- input Name -->
                        <label class="form-label mb-0 mt-1 font-weight-bold" for="Name"><span
                                    class='text-info'>Name</span></label>
                        <input class="form-control" type="text" name="Name" id="name"
                               placeholder="Name">
                        <!-- input Email -->
                        <label class="form-label mb-0 mt-1 font-weight-bold" for="email"><span
                                    class='text-info'>Email</span></label>
                        <input class="form-control" type="email" name="Email" id="email"
                               placeholder="Email">
                        <!-- input your comment -->
                        <label class="form-label mb-0 mt-1 font-weight-bold" for="commentarea"><span class="text-info">Comment</span></label>
                        <textarea name="Comment" id="commentarea" class="form-control"></textarea>
                        <!-- Add new Post btn -->
                        <br><input class="btn btn-primary" type="Submit" name="Submit"
                                   value="Submit"><br>
                    </fieldset>
                </form>
            </div> <!-- Comments End -->

        </div><!-- Main blog end -->
        <div class="offset-1 col-sm-3"> <!-- Side Area -->
            <h2>About me</h2>
            <img src="images/8.PNG" class="img-fluid">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <hr>



            <div class="card border border-primary"><!-- card 1 -->
                <div class="card-body bg-primary rounded-top text-light">
                    <h2>Categories</h2>
                </div>
                <div class="list-group list-group-flush">
                        <span class="list-group-item border-bottom-0">
                            <?php
                            global $connection;
                            $viewQuery = "SELECT * FROM category ORDER BY datetime desc ";
                            $execute = mysqli_query($connection,$viewQuery);
                            while ($dataRows=mysqli_fetch_array($execute)){
                                $id = $dataRows['id'];
                                $category = $dataRows['name'];
                                ?>
                                <a href="Blog.php?Category=<?php echo $category;?>">
                                <span class="font-weight-bold text-primary"><?php echo $category."<br>";?></span></a>
                            <?php } //end of while loop  ?>
                        </span>
                </div>
                <div class="card-footer"></div>
            </div><!-- card 1 end -->
            <br>
            <div class="card border border-primary"><!-- card 2 -->
                <div class="card-body bg-primary rounded-top text-light">
                    <h2>Recent Posts</h2>
                </div>
                <div class="list-group list-group-flush">
                        <span class="list-group-item border-bottom-0 bg-light">
                            <?php
                            global $connection;
                            $viewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
                            $execute = mysqli_query($connection,$viewQuery);
                            while ($dataRows=mysqli_fetch_array($execute)){
                                $id = $dataRows['id'];
                                $title = $dataRows['title'];
                                $dateTime = $dataRows['datetime'];
                                $image = $dataRows['image'];
                                if (strlen($dateTime)>12){ $dateTime = substr($dateTime,0,12);}
                                ?>
                                <div>
                                    <hr>
                                    <img class="mt-1 ml-1 float-left rounded" src="upload/<?php echo $image;?>" width="50" height="50">
                                    <a href="FullPost.php?id=<?php echo $id;?>" target="_blank"><p class="font-weight-bold text-info" style="margin-left: 70px"><?php echo $title;?></p></a>
                                    <p style="margin-left: 70px"><?php echo $dateTime;?></p>
                                </div>
                            <?php } //end of while loop  ?>
                        </span>
                </div>
                <div class="card-footer"></div>
            </div><!-- card 2 end -->

        </div> <!-- Side Area end -->
    </div><!-- row end -->
</div><!-- Container end -->
<div class="text-light font-weight-bold p-2 border-top bg-dark text-center" id="footer">
    <hr>
    <p>Theme By | Babak Moeinifar | &copy;2018 --- All right reserved.</p>
    <p>This is site for testing PHP CMS</p>
    <hr>
</div>
<div class="bg-info" style="height: 10px">
</body>
</html>