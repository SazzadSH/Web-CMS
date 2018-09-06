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

if($user_type_id != 1)
{
    header("Location: ./");
}

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

<?php
if (empty($_GET["id"])) {
    $isUpdate = false;
}
else {
    $category_id=$_GET["id"];

    $isUpdate = true;

}


$con = mysqli_connect("localhost", "root", "", "blog_cms");
if (!$con) {
    die("error! " . mysqli_connect_error());
}
else {

    $sql2 = "SELECT user_type_id FROM users WHERE username='" . $username . "';";
    $res = mysqli_query($con, $sql2);
    if (mysqli_num_rows($res) > 0) {
        $row1 = mysqli_fetch_array($res);
        $user_type_id = $row1['user_type_id'];
    } else {
        echo "username doesn't exist." . '<br>' . $con->error;
    }
    if($user_type_id!=1){
        header("location:dashboard.php");
    }
}

if($isUpdate){
    $sql="select category_name from category WHERE category_id='".$category_id."'";
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $category_name=$row['category_name'];
    }
    else{
        $category_name="";
    }
}



$con->close();
?>

<?php
if (isset($_POST['submit_cat'])) {

    if (isset($_POST["cat_id"])) {
        $isUpdate = true;
    }

    if ($_POST['category_txt'] == "") {
        echo "hoy nai post";
        header("location:new_category.php");
    }
    $con = mysqli_connect("localhost", "root", "", "blog_cms");
    if (!$con) {
        die("error! " . mysqli_connect_error());
    } else {



        $category_name = $_POST['category_txt'];

        if ($isUpdate) {
            $sql = "update category set category_name='" . $category_name . "' where category_id='" . $category_id . "'";
            if ($con->query($sql)) {
                echo "success";
                header("location:category_admin.php");
            } else echo "failed";
        } else {
            $sql = "insert into category (category_name) VALUES ('" . $category_name . "')";
            if ($con->query($sql)) {
                echo "success";
                header("location:category_admin.php");
            } else echo "failed";
        }


    }
    $con->close();
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
    <title>Category | Dashboard</title>

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
                            <a class="js-arrow" href="dashboard.php">
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


                            echo "<li class=\"active has-sub\">
                            <a class=\"js-arrow\" href=\"category_admin.php\">
                                <i class=\"fa fa-table\"></i>Categories</a>
                        </li>";
                        }
                        
                        ?>

                        

                        <li>
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


                            echo "<li class=\"active has-sub\">
                            <a class=\"js-arrow\" href=\"category_admin.php\">
                                <i class=\"fa fa-table\"></i>Categories</a>
                        </li>";
                        }
                        
                        ?>

                        

                        <li>
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
                        <div class="col-md-12">
                            <div class="overview-wrap">
                                <h2 class="title-1">Categories</h2>
                                <a href="new_post.php">
                                    <button class="au-btn au-btn-icon au-btn--blue">
                                        <i class="zmdi zmdi-plus"></i>Add New Post</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="main-content" align="center">
                        <!-- Content goes here -->



                        <?php if ($isUpdate) {?>
                            <h1>Edit Category Name</h1>
                            <input type="hidden" name="cat_id" value="<?php echo $category_id ?>">
                        <?php } else {?>
                            <h1>Add New Category</h1>
                        <?php } ?>
                        <form method="POST" onsubmit="return confirm('Are you confirm to add category?');">
                            <p>Category Name</p>

                            <input type="text" name="category_txt" value="<?php if ($isUpdate) echo $category_name; else echo "";?>"
                            >

                            <br>
                            <input type="submit" name="submit_cat" value= <?php if ($isUpdate) {?> "Update" <?php } else {?> "Save" <?php } ?>>
                        </form>




                        <!-- Content Ends-->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2018 <a href="#">bCMS</a>.</p>
                            </div>
                        </div>
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
