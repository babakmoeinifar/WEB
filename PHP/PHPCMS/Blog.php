<?php require_once("include/DB.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="maps/glyphicons-fontawesome.min.css">
    <link rel="stylesheet" href="style/publicstyles.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Blog</title>
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
                <li class="nav-item active"><a class="nav-link text-light" href="Blog.php">Blog</a></li>
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
<!-- End of Navigation bar -->

<div class="container">
    <div class="blog-header">
        <br>
        <h1>The complete responsive CMS blog</h1>
        <p class="lead">The complete blog using PHP by Babak Moeinifar</p>
    </div>
    <div class="row">
        <div class="col-sm-8"> <!-- Main Blog Area -->
                <?php
                global $connection;
                //Query when search button is active
                if (isset($_GET['SearchButton'])) {
                    $search = $_GET['Search'];
                    $viewQuery = "SELECT * FROM admin_panel 
                              WHERE datetime LIKE '%$search%' 
                              OR title LIKE '%$search%' 
                              OR category LIKE '%$search%' 
                              OR post LIKE '%$search%'";
                }//Query when category is activate by client in URL from sidebar card onclick
                elseif (isset($_GET['Category'])) {
                    $category = $_GET['Category'];
                    $viewQuery = "SELECT * FROM admin_panel WHERE category='$category' ORDER BY datetime DESC";
                }//Query when Pagination is Active for example Blog.php?Page=1
                elseif (isset($_GET['Page'])) {
                    $page = $_GET['Page'];
                    //if Page number inserted by client <= 1
                    if ($page <= 1) {
                        $showPostFrom = 0;
                    } else {
                        $showPostFrom = ($page * 5) - 5; //Pagination Algorithm for 5 posts in page
                    }

                    $viewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $showPostFrom,5";
                } //Default Query of Blog.php page
                else {

                    $viewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
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
                    <div class="img-thumbnail blogpost text-center mb-3">
                        <img class="rounded img-fluid" src="upload/<?php echo $image; ?>">
                        <div class="figure-caption text-left">
                            <h2 id="heading"><?php echo htmlentities($title); ?></h2>
                            <p id="catpost" class="text-info">Category:<?php echo htmlentities($category); ?><br>
                                Published on: <?php echo htmlentities($dateTime); ?></p>
                            <p id="postentities"><?php
                                if (strlen($post) > 150) {
                                    //show continue... of post
                                    $post = substr($post, 0, 150) . '...'; //Extract 150 charcters of post
                                }
                                echo $post; ?></p>
                            <a href="FullPost.php?id=<?php echo $postId; ?>">
                                <span class="btn btn-info float-left mb-2">Read More &rsaquo;&rsaquo;</span>
                            </a>
                        </div>
                    </div><!-- ending of card post  -->
                <?php } //end of while ?>
                <nav>
                    <ul class="pagination">
                        <?php //Back button
                        global $page;
                        if ($page > 1){ ?>
                        <li class="page-item"><a class="page-link"
                                                 href="Blog.php?Page=<?php echo $page - 1; ?>">&laquo;</a>
                        </li>
                        <?php } //end of if $page > 1?><!-- end of Back Button-->

                        <?php
                        global $connection;
                        $queryPagination = "SELECT COUNT(*) FROM admin_panel";
                        $executePagination = mysqli_query($connection, $queryPagination);
                        $rowPagination = mysqli_fetch_array($executePagination);
                        $totalPosts = array_shift($rowPagination);
                        $postPagination = $totalPosts / 5;
                        $postPagination = ceil($postPagination);
                        //Loop for counting PagesFolder (1 2 3 4 5 ...)
                        for ($i = 1;
                             $i <= $postPagination;
                             $i++) {
                            if (isset($page)) {
                                if ($i == $page) {
                                    ?>

                                    <li class="active page-item">
                                        <a class="page-link"
                                           href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } //end of if for active class
                                else { ?>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php }//end of else for other PagesFolder tha are not actice
                            }//end of if isset  $page
                            else {
                                $page = $page + 1;
                            }
                        }//end of for i loop?>
                        <?php //Forward button
                        global $page;
                        if ($page + 1 <= $postPagination){ ?>
                        <li class="page-item"><a class="page-link"
                                                 href="Blog.php?Page=<?php echo $page + 1; ?>">&raquo;</a>
                        </li>
                        <?php } //end of if $page > 1?><!-- end of Forward Button-->
                    </ul>
                </nav><!-- end of PagesFolder (1 2 3 4 .. )-->

            </div>


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
                            $execute = mysqli_query($connection, $viewQuery);
                            while ($dataRows = mysqli_fetch_array($execute)) {
                                $id = $dataRows['id'];
                                $category = $dataRows['name'];
                                ?>
                                <a href="Blog.php?Category=<?php echo $category; ?>">
                                <span class="font-weight-bold text-primary"><?php echo $category . "<br>"; ?></span></a>
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
                            $execute = mysqli_query($connection, $viewQuery);
                            while ($dataRows = mysqli_fetch_array($execute)) {
                                $id = $dataRows['id'];
                                $title = $dataRows['title'];
                                $dateTime = $dataRows['datetime'];
                                $image = $dataRows['image'];
                                if (strlen($dateTime) > 12) {
                                    $dateTime = substr($dateTime, 0, 12);
                                }
                                ?>
                                <div>
                                    <hr>
                                    <img class="mt-1 ml-1 float-left rounded" src="upload/<?php echo $image; ?>"
                                         width="50" height="50">
                                    <a href="FullPost.php?id=<?php echo $id; ?>" target="_blank"><p
                                                class="font-weight-bold text-info"
                                                style="margin-left: 70px"><?php echo $title; ?></p></a>
                                    <p style="margin-left: 70px"><?php echo $dateTime; ?></p>
                                </div>
                            <?php } //end of while loop  ?>
                        </span>
                </div>
                <div class="card-footer"></div>
            </div><!-- card 2 end -->

        </div><!-- Ending Main blog end -->
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