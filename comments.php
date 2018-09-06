<?php
    session_start();

    if(isset($_GET['logout']) && $_GET['logout'] == 1)
    {
        session_unset();
        session_destroy();
    }

    if(!isset($_SESSION['username']))
    {
        header("Location: ./");
    }
    else if($_SESSION['is_active'] != 1)
    {
        header("Location: ./?active=0");
    }

    $name = "";
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];
    $user_type_id = $_SESSION['user_type_id'];
    $imgpath = "assets/images/icon/avatar-01.jpg";

    if(!isset($_SESSION['name']))
    {
        $name = "";

        $con = mysqli_connect("localhost", "root", "", "blog_cms");
        $sql = "select * from persons where user_id='".$user_id."'";

        if(!$con)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = mysqli_query($con, $sql);

        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

        $_SESSION['name'] = $row['person_name'];
        $_SESSION['person_id'] = $row['person_id'];
        $_SESSION['gender'] = $row['gender'];
        $_SESSION['dob'] = $row['date_of_birth'];
        $_SESSION['img'] = $row['imagepath'];

    }

    $name = $_SESSION['name'];

    if($_SESSION['img'] != "")
    {
        $imgpath = $_SESSION['img'];
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Comments | Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="assets/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="#">
                            <h1>Dashboard</h1>
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                    <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-desktop"></i>Overview</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-edit"></i>Post</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="new_post.php">New Post</a>
                                </li>
                                <li>
                                    <a href="post.php">Manage Posts</a>
                                </li>
                            </ul>
                        </li>
                        <?php
                        
                        if($user_type_id == 1)
                        {
                            echo "<li class=\"has-sub\">
                                <a class=\"js-arrow\" href=\"#\">
                                  <i class=\"fa fa-fw fa-file\"></i>Page</a>
                                <ul class=\"list-unstyled navbar__sub-list js-sub-list\">
                                    <li>
                                       <a href=\"new_page.php\">New Page</a>
                                    </li>
                                    <li>
                                        <a href=\"manage_pages.php\">Manage Page</a>
                                    </li>
                                </ul>
                            </li>";


                            echo "<li>
                            <a class=\"js-arrow\" href=\"category_admin.php\">
                                <i class=\"fa fa-table\"></i>Categories</a>
                        </li>";
                        }
                        
                        ?>

                        

                        <li class="active">
                            <a class="js-arrow" href="comments.php">
                                <i class="zmdi zmdi-comment-more"></i>Comments</a>
                        </li>

                        <?php
                        
                        if($user_type_id == 1)
                        {
                            echo "<li>
                            <a class=\"js-arrow\" href=\"template.php\">
                                <i class=\"fa fa-bar-chart-o\"></i>Template</a>
                        </li>";


                            echo "<li>
                            <a class=\"js-arrow\" href=\"user_management.php\">
                                <i class=\"fa fa-tasks fa-fw\"></i>User Management</a>
                            </li>";


                        }
                        
                        ?>

                        <li>
                        <li>
                            <a class="js-arrow" href="profile.php">
                                <i class="fa fa-user fa-fw"></i>Profile</a>
                        </li>



                        
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="dashboard.php">
                    <h1>Dashboard</h1>
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-desktop"></i>Overview</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-edit"></i>Post</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="new_post.php">New Post</a>
                                </li>
                                <li>
                                    <a href="manage_posts.php">Manage Posts</a>
                                </li>
                            </ul>
                        </li>

                        <?php
                        
                        if($user_type_id == 1)
                        {
                            echo "<li class=\"has-sub\">
                                <a class=\"js-arrow\" href=\"#\">
                                  <i class=\"fa fa-fw fa-file\"></i>Page</a>
                                <ul class=\"list-unstyled navbar__sub-list js-sub-list\">
                                    <li>
                                       <a href=\"new_page.php\">New Page</a>
                                    </li>
                                    <li>
                                        <a href=\"manage_pages.php\">Manage Page</a>
                                    </li>
                                </ul>
                            </li>";


                            echo "<li>
                            <a class=\"js-arrow\" href=\"category_admin.php\">
                                <i class=\"fa fa-table\"></i>Categories</a>
                        </li>";
                        }
                        
                        ?>

                        

                        <li class="active">
                            <a class="js-arrow" href="comments.php">
                                <i class="zmdi zmdi-comment-more"></i>Comments</a>
                        </li>

                        <?php
                        
                        if($user_type_id == 1)
                        {
                            echo "<li>
                            <a class=\"js-arrow\" href=\"template.php\">
                                <i class=\"fa fa-bar-chart-o\"></i>Template</a>
                        </li>";


                            echo "<li>
                            <a class=\"js-arrow\" href=\"user_management.php\">
                                <i class=\"fa fa-tasks fa-fw\"></i>User Management</a>
                            </li>";


                        }
                        
                        ?>

                        <li>
                            <a class="js-arrow" href="profile.php">
                                <i class="fa fa-user fa-fw"></i>Profile</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="form-header"></div>
                            <div class="header-button">
                                
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="<?php echo $imgpath; ?>" alt="<?php echo $name; ?>" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="profile.php"><?php echo $name; ?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="<?php echo $imgpath; ?>" alt="<?php echo $name; ?>" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="profile.php"><?php echo $name; ?></a>
                                                    </h5>
                                                    <span class="email"><?php echo $email; ?></span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="?logout=1">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div>
                                <div class="overview-wrap">
                                    <h2 class="title-1">Comments</h2>
                                    
                                </div>
                            </div>
                        </div>
                        <div>
                            <br><h4>Unapproved Comments</h4><br>
                        </div>
                        <div class="row">
                        <!-- Content goes here -->
                        
                            <?php

                                /*Comment Operation*/
                                /*Comment List Presentation*/

                                $commentSQL = "SELECT comments.comment_id, comments.name, comments.email, comments.comment, posts.title, comments.is_approved, comments.is_active FROM comments INNER JOIN posts ON comments.post_id=posts.post_id AND posts.user_id=".$user_id;
                                
                                $con = mysqli_connect("localhost", "root", "", "blog_cms");

                                if($user_type_id == 1)
                                {
                                    $commentSQL = "SELECT comments.comment_id, comments.name, comments.email, comments.comment, posts.title, comments.is_approved, comments.is_active FROM comments INNER JOIN posts ON comments.post_id=posts.post_id";
                                }

                                $commentList=$con->query($commentSQL);
                            ?>
                            
                            
                            <table>
                                <col width="100">
                                <col width="100">
                                <col width="250">
                                <col width="300">
                                <col width="350">
                                <col width="100">

                                <th>
                                    ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Comment
                                </th>
                                <th>
                                    Post Title
                                </th>
                                <th>
                                    Action
                                </th>
                                
                                <?php

                                    foreach($commentList as $comRow)
                                    {
                                        if($comRow['is_approved'] == 0 && ($comRow['is_active'] == 1 || $user_type_id == 1))
                                        {
                                            echo "<tr>";
                                            echo "<td>";
                                            echo $comRow['comment_id'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $comRow['name'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $comRow['email'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $comRow['comment'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $comRow['title'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo "<a href=\"comment_mgt.php?approve=".$comRow['comment_id']."\">Approve</a>";
                                            if($user_type_id == 1)
                                            {
                                                echo "<a href=\"comment_mgt.php?delete=".$comRow['comment_id']."\">Delete</a>";
                                            }
                                            else
                                            {
                                                echo "<a href=\"comment_mgt.php?remove=".$comRow['comment_id']."\">Remove</a>";
                                            }
                                            echo "</td>";
                                        }
                                    }
                                ?>

                            </table>

                        </div>

                        <div>
                            <br><h4>Approved Comments</h4><br>
                        </div>

                        <div class="row">
                        
                            <table>
                                <col width="100">
                                <col width="100">
                                <col width="250">
                                <col width="300">
                                <col width="350">
                                <col width="100">

                                <th>
                                    ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Comment
                                </th>
                                <th>
                                    Post Title
                                </th>
                                <th>
                                    Action<?php echo $user_type_id; ?>
                                </th>
                                
                                <?php

                                    foreach($commentList as $comRow)
                                    {
                                        if($comRow['is_approved'] == 1 && ($user_type_id == 1 || $comRow['is_active'] == 1))
                                        {
                                            echo "<tr>";
                                            echo "<td>";
                                            echo $comRow['comment_id'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $comRow['name'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $comRow['email'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $comRow['comment'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo $comRow['title'];
                                            echo "</td>";

                                            echo "<td>";
                                            echo "<a href=\"comment_mgt.php?unapprove=".$comRow['comment_id']."\">Unapprove</a>";
                                            if($user_type_id == 1)
                                            {
                                                echo "<a href=\"comment_mgt.php?delete=".$comRow['comment_id']."\">Delete</a>";
                                            }
                                            else
                                            {
                                                echo "<a href=\"comment_mgt.php?remove=".$comRow['comment_id']."\">Remove</a>";
                                            }
                                            echo "</td>";
                                        }
                                    }
                                ?>

                            </div>

                        
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="assets/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="assets/vendor/slick/slick.min.js">
    </script>
    <script src="assets/vendor/wow/wow.min.js"></script>
    <script src="assets/vendor/animsition/animsition.min.js"></script>
    <script src="assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="assets/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="assets/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="assets/vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="assets/js/main.js"></script>

</body>

</html>
<!-- end document-->
