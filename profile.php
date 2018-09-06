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
    <title>Overview | Dashboard</title>

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
    <div class="animsition">
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

                        <li class="active">
                            <a class="js-arrow" href="profile.php">
                                <i class="fa fa-user fa-fw"></i>Profile</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        </div>
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Content goes here -->

                        <form action="ProfileValidation.php" method="post" enctype="multipart/form-data">
                        <div class = 'InnerBorder'>

                            <div class="profilepic">
                                <img src="<?php if(strlen($_SESSION['img'])!=0){echo $_SESSION['img'];}else{echo "assets/images/icon/avatar-01.jpg";} ?>" align="left" height="200px" width="100" id='avatar'/><br><br><br>

                            </div>
                            <div class = "profilebutton">
                                <input type="file" id="filepath" accept='image/*' value="Choose Picture" name="selected_file" onchange="readURL(event);"><br>
                                <div id = "filepathinfo"></div>
                            </div>

                            <div class = "otherinfo">
                                <table>
                                    <tr>
                                        <td><font size="5px">Name</font></td>
                                        <td><input type="text" id="name" placeholder="Name" <?php echo 'value = "'.$_SESSION['name'].'"' ?> name = "myname" oninput="mynameFunction()"/>
                                            <div id="namevalidate"><?php echo $_SESSION['errorname'] ?></div></td>

                                    </tr>
                                    <tr>
                                        <td><font size='5px'>New Password:</font></td>
                                        <td><input type="password" id="newpassword" placeholder="New Password" <?php echo 'value = "'.$_SESSION['newpass'].'"' ?> name = "newpassword" oninput="mynewFunction()"/>
                                            <div id="newpass"></div></td>
                                    </tr>
                                    <tr>
                                        <td><font size='5px'>Repeat New Password:</font></td>
                                        <td><input type="password" id="repeatpassword" placeholder="Repeat New Password" name="repeatnewpassword" oninput="myrepeatFunction()"/><br>
                                            <div id="repeatpass"><?php echo $_SESSION['errorpass'] ?></div></td>
                                    </tr>
                                    <tr>
                                        <td><font size='5px'>Gender:</font></td>
                                        <td><input type="radio" name="gender" value="male"<?php if($_SESSION['gender']=="male"){echo "checked";} else if($_SESSION['gender']==""){echo "checked";} ?> />Male <input type="radio" name="gender" <?php if($_SESSION['gender']=="female"){echo "checked";} ?> value="female"/>Female <input type="radio" name="gender" <?php if($_SESSION['gender']=="other"){echo "checked";} ?>  value="other"/>Other</td>
                                    </tr>
                                    <tr>
                                        <td><font size = '5px'>Date Of Birth:</font></td>
                                        <td><input type="date" id="myDate" name ="mydateofbirth1" <?php echo 'value = "'.$_SESSION['dob'].'"' ?> oninput="mydateofbirthvalidation()" /><br></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><div id="validatedob">Month / Date / Year</div>
                                            <div id="validatedob1"><?php echo $_SESSION['errordob'] ?></div><br></td>
                                    </tr>
                                </table>












                            </div>
                            <div class = "updatebutton">
                                <input type="submit" value="UPDATE" name="UpdateEdit"/>
                            </div>
                            <script>
                                var namecounter=0;
                                var newpasscounter=0;
                                var repeatpasscounter=1;
                                var aboutmecounter=0;
                                function mynameFunction()
                                {
                                    var name = document.getElementById("name").value;
                                    var namesize=name.length;

                                    if(namesize<=50)
                                    {
                                        document.getElementById("namevalidate").innerHTML = "";
                                        namecounter=0;
                                    }
                                    else if(namesize>50)
                                    {
                                        document.getElementById("namevalidate").innerHTML = "Name Length Must Be within 50 Characters";
                                        namecounter=1;
                                    }
                                }
                                function mynewFunction()
                                {
                                    var pass = document.getElementById("newpassword").value;
                                    var passsize = pass.length;

                                    if(passsize==0)
                                    {
                                        document.getElementById("repeatpass").innerHTML = "";
                                        repeatpasscounter=0;
                                        document.getElementById("repeatpassword").value = "";
                                    }
                                    else if(passsize>=8)
                                    {
                                        document.getElementById("newpass").innerHTML = "";
                                        newpasscounter=0;
                                        myrepeatFunction();
                                    }
                                    else if(passsize<8)
                                    {
                                        document.getElementById("newpass").innerHTML = "Password Must Be 8 Characters";
                                        document.getElementById("repeatpass").innerHTML = "";
                                        newpasscounter=1;
                                        myrepeatFunction();
                                    }

                                }
                                function myrepeatFunction()
                                {
                                    var repeatpass1 = document.getElementById("repeatpassword").value;
                                    var newpass1 = document.getElementById("newpassword").value;

                                    if(newpass1.length<8)
                                    {
                                        document.getElementById("repeatpass").innerHTML = "Error in New Password";
                                    }
                                    else if(newpass1.length==0)
                                    {
                                        document.getElementById("repeatpass").innerHTML = "";
                                    }

                                    else if(repeatpass1.length==0)
                                    {
                                        document.getElementById("repeatpass").innerHTML = "";
                                        repeatpasscounter=0;
                                    }

                                    else if(repeatpass1==newpass1)
                                    {
                                        document.getElementById("repeatpass").innerHTML = "Match";
                                        repeatpasscounter=0;
                                    }
                                    else
                                    {
                                        document.getElementById("repeatpass").innerHTML = "Unmatch";
                                        repeatpasscounter=1;
                                    }
                                }

                                function readURL(event)
                                {
                                    var reader = new FileReader();
                                    reader.onload = function()
                                    {
                                        var output = document.getElementById('avatar');
                                        output.src = reader.result;
                                    }
                                    reader.readAsDataURL(event.target.files[0]);
                                }

                                function mydateofbirthvalidation()
                                {
                                    var dateofbirth = new Date (document.getElementById("myDate").value);
                                    //document.getElementById("myDate").value = "1997-11-11";//dateofbirth.getFullYear()."-".dateofbirth.getMonth()."-".dateofbirth.getDate();
                                    var year = dateofbirth.getFullYear();
                                    var month = dateofbirth.getMonth();
                                    var day = dateofbirth.getDate();
                                    var currentdate = new Date();
                                    currdate = currentdate.getDate();
                                    currmonth = currentdate.getMonth();
                                    curryear = currentdate.getFullYear();
                                    if(year>curryear)
                                    {
                                        document.getElementById("validatedob1").innerHTML = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspError Date Of Birth";
                                    }
                                    else if(year==curryear)
                                    {
                                        if(month>currmonth)
                                        {
                                            document.getElementById("validatedob1").innerHTML = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspError Date Of Birth";
                                        }
                                        else if(month==currmonth)
                                        {
                                            if(day>currdate)
                                            {
                                                document.getElementById("validatedob1").innerHTML = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspError Date Of Birth";
                                            }
                                            else if(day==currdate)
                                            {
                                                document.getElementById("validatedob1").innerHTML = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspError Date Of Birth";
                                            }
                                            else
                                                document.getElementById("validatedob1").innerHTML = "";
                                        }
                                        else
                                            document.getElementById("validatedob1").innerHTML = "";
                                    }
                                    else
                                    {
                                        document.getElementById("validatedob1").innerHTML = "";
                                    }
                                    //alert(currentdate.getFullYear());
                                    //alert(currentdate.getMonth());
                                    //alert(currentdate.getDate());

                                }
                            </script>
                        </div>
                        </form>

                        <!--Content ends here-->
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
