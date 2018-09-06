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

<?php
if (empty($_GET["id"])) {
    $isUpdate = false;
}
else {
    $post_id=$_GET["id"];
    $post_id2=$_GET['id'];
    $isUpdate = true;

}
//$setSelected=true;
$categoryIdWhereSetSelected=0;
//echo $id;
?>

<?php
//        $post_title = $post_body = "";
$post_time = date("Y-m-d h:i:sa");

//$post_id = fread(fopen("postcount.txt", "r"), filesize("postcount.txt"));

if( isset( $_POST["submit_btn"] ) )
{
    if (isset($_POST["post_id"])) {
        $post_id = $_POST["post_id"];
        $isUpdate = true;
    }
    $post_title = $_POST["title_txt"];
    $post_body = $_POST["post_txt"];
    $username=$_SESSION['username'];
    $created_date = date("Y-m-d h:i:s");
    $modified_date = date("Y-m-d h:i:s");
    $user_id="";
    $tags=$_POST['tags_txt'];

//            $post_file = fopen("./posts/".$post_id.".txt", "w");
//            fwrite($post_file, $post_id."\r\n");
//            fwrite($post_file, $post_time."\r\n");
//            fwrite($post_file, $post_title."\r\n");
//            fwrite($post_file, $post_body);
//            fclose($post_file);
//
//            $post_id++;
//            fwrite(fopen("postcount.txt", "w"), $post_id);

    $con = mysqli_connect("localhost", "root", "", "blog_cms");
    if (!$con) {
        die("error! " . mysqli_connect_error());
    } else {
        $sql_post_cat="";

        if($post_title=="" || $post_body==""){
            echo "hoy nai post";
            header("location:new_post.php");
        }
        else {
            $sql2 = "SELECT user_id FROM users WHERE username='" . $username . "';";
            $res = mysqli_query($con, $sql2);
            if (mysqli_num_rows($res) > 0) {
                $row1 = mysqli_fetch_array($res);
                $user_id = $row1['user_id'];
            } else {
                echo "username doesn't exist." . '<br>' . $con->error;
            }

            if (!$isUpdate){
                echo "Insert";
                $sql = "INSERT INTO posts (title, body, created_date, modified_date, user_id, is_active) VALUES ('" . $post_title . "','" . $post_body . "','" . $created_date . "','" . $modified_date . "','" . $user_id . "','1');";

            }else{
                echo "Update";
                $sql = "UPDATE posts SET title='".$post_title."', body='".$post_body."',modified_date='".$modified_date."'  WHERE post_id='".$post_id."'";
            }
            if ($con->query($sql)) {
                echo "success";
                $sql_post_cat="SELECT post_id FROM posts ORDER BY post_id DESC LIMIT 0, 1";


            } else {
                echo "failed: " . $con->error;
            }

            $post_id="";
            $res=$con->query($sql_post_cat);
            if(mysqli_num_rows($res)>0){
                $row1=mysqli_fetch_array($res);
                $post_id=$row1['post_id'];
            }

            if(!$isUpdate) {
                $checkInsert = false;
                $category_id = $_POST['category_id'];
                $sql = "INSERT INTO post_category (category_id, post_id) VALUES ('" . $category_id . "','" . $post_id . "')";
                if ($con->query($sql)) {
                    echo "success";
                    $checkInsert = true;
                } else {
                    $checkInsert = false;
                }
                if (!empty($tags)) {
                    $ar = explode(",", $tags);
                    for ($i = 0; $i < sizeof($ar); $i++) {
                        $tag = trim($ar[$i]);
                        if (!empty($tag))
                            if (preg_match("/^[a-zA-Z0-9_]+$/", $tag)) {
                                $sql = "INSERT INTO tags (tag_name, post_id) VALUES (LOWER('" . $tag . "'),'" . $post_id . "');";
                                if ($con->query($sql)) {
                                    echo "success";
                                    $checkInsert = true;
                                } else {
                                    $checkInsert = false;
                                    break;
                                }
                            } else continue;
                    }
                }

                if ($checkInsert) {
                    header("location:manage_posts.php");
                }
                else echo "post jay nai";
            }



            else{
                echo "update e dhukse";
                $checkUpdate=false;

                $category_id=$_POST['category_id'];
                if(($_POST['isSetSelected'])=="noCat"){
                    $setSelected=false;
                }
                else{
                    $setSelected=true;
                }

                if($setSelected)
                {
                    $sql="UPDATE post_category SET category_id='".$category_id."' where post_id='".$post_id2."';";
                    if($con->query($sql)){
                        $checkUpdate=true;
                        echo " category update hoise";
                    }
                    else $checkUpdate=false;

                }
                else
                {
                    $category_id=$_POST['category_id'];
                    $sql="INSERT INTO post_category (category_id, post_id) VALUES ('".$category_id."','".$post_id2."')";
                    if($con->query($sql)){

                        //echo $setSelected;
                        $checkUpdate=true;
                    }
                    else $checkUpdate=false;
                }

                $sql="SELECT * FROM tags WHERE post_id='".$post_id2."'";
                $res=$con->query($sql);


                if (!empty($tags)) {
                    echo " tags empty na ";
                    $tagNew=true;
                    $ar = explode(",", $tags);
                    for ($i = 0; $i < sizeof($ar); $i++) {
                        echo " first for loop e dhukse ".$i." bar".'<br>';
                        echo $_POST['tags_txt'];
                        $tag = trim($ar[$i]);
                        echo " ".$tag.'<br>';
                        if (!empty($tag)) {
                            //echo " tag empty na ";
                            if ($res->num_rows > 0) {
                                foreach ($res as $row) {
                                    if ($tag == $row['tag_name']) {
                                        echo $row['tag_name'].'<br>';
                                        $tagNew = false;
                                        echo " tag new false 1 ";
                                        break;
                                    }
                                    else {
                                        echo " tag new true 1 ";
                                        $tagNew=true;

                                    }
                                }
                            }
                            if (preg_match("/^[a-zA-Z0-9_]+$/", $tag)) {
                                echo " tagNew= ".$tagNew.'<br>';

                                echo " preg match korse ".$post_id2." ";
                                if(!$tagNew){echo "tag new false"; continue;} else echo " tag new true 2 ";
                                echo $tags.'<br>';
                                $sqlT = "INSERT INTO tags (tag_name, post_id) VALUES (LOWER('" . $tag . "'),'" . $post_id2 . "');";
                                if ($con->query($sqlT)) {
                                    echo " tag success ";
                                    $checkUpdate = true;
                                }
                                else {
                                    echo $con->error;
                                    echo "tag fail ";
                                    $checkUpdate = false;
                                    break;
                                }
                            }
                            else {echo " preg match korenai ".$tagNew; continue;}
                        }
                    }
                }
                if ($checkUpdate) {
                    echo "tag Update hoise";
                    header("location:manage_posts.php");
                }
                else echo "tag update hoy nai atkaya gese";
            }
        }

    }

    //$con->close();
}


?>

<?php
if ($isUpdate) {
    $con = mysqli_connect("localhost", "root", "", "blog_cms");
    if (mysqli_connect_error()) {
        echo "Failed to connect to mysql: " . mysqli_connect_error();
    } else {
        $user_id = 0;
        $sql2 = "SELECT user_id FROM users WHERE username='" . $username . "';";
        $res = mysqli_query($con, $sql2);
        if (mysqli_num_rows($res) > 0) {
            $row1 = mysqli_fetch_array($res);
            $user_id = $row1['user_id'];
        }
        else {
            echo "username doesn't exist." . '<br>' . $con->error;
        }
        //$post_id=$_GET['post_id'];
        $sql = "SELECT * FROM posts WHERE user_id='" . $user_id . "' AND is_active=1 AND post_id='" . $post_id . "';";
        $res = $con->query($sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
        } else {
            echo "username doesn't match" . '<br>' . $con->error;
            if($user_id != $row['user_id']){
                header("location:manage_posts.php");
            }
            echo $user_id." ".$_SESSION['user_id']." ";
            header("location:manage_posts.php");
        }
    }

    $con->close();
}
//if(isset($_GET['post_id'])){
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

<body>
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
                        <li class="active has-sub">
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
                        <li class="active has-sub">
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

                        <li>
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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./css/generic.css" />
    <script src="main.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
</head>
<body>




    <div class="wrapper" style="height: auto">
        <div class="topbar">
            
        </div>
        <div class="main">
<!--            <div class="main_content">-->
<!--                <form action="new_post.php" method="POST">-->
<!--                    <h1>New Post</h1>-->
<!--                    <p>Title:</p>-->
<!--                    <input type="text" size="100" name="title_txt" value="--><?php //echo $post_title; ?><!--">-->
<!--                    <p>Post:</p>-->
<!--                    <td><textarea name="post_txt" style="width:615px; height:500px">--><?php //echo $post_body; ?><!--</textarea><br />-->
<!--                    <input type="submit" name="submit_btn" value="Save">-->
<!--                </form>-->
<!--            </div>-->


                <div class="main_content">
                    <form method="POST" onsubmit="return confirm('Are you sure to post this?');">
                        <?php if ($isUpdate) {?>
                            <h1>Edit Post</h1>
                            <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                        <?php } else {?>
                            <h1>New Post</h1>
                        <?php } ?>
                        <p>Title:</p>
                        <input type="text" size="100" name="title_txt" value="<?php if ($isUpdate) echo $row['title']; ?>">
                        <?php
                            if($isUpdate){
                                echo '<br>'."Created Date: ".$row['created_date'].'<br>'."Last Modified: ".$row['modified_date'].'<br>';
                            }
                        ?>
                        <p>Post:</p>
                        <textarea name="post_txt" id="post_txt"
                                      ><?php if ($isUpdate) echo $row['body']; ?>
                        </textarea>
                        <br/>
                        <script>
                            CKEDITOR.replace("post_txt");
                        </script>
                            <p>Category:</p>

                                <?php
                                $con = mysqli_connect("localhost", "root", "", "blog_cms");
                                if (mysqli_connect_error()) {
                                    echo "Failed to connect to mysql: " . mysqli_connect_error();
                                }
                                else {
                                    if (!$isUpdate) {
                                        $setSelected = true;
                                        $categoryIdWhereSetSelected = 0;
                                        $sqlcat = "select * from category";
                                        $filter = $con->query($sqlcat);
                                        //$menu = "";
                                        echo "<select name=\"category_id\" id=\"category_id\">";
                                        while ($r = mysqli_fetch_array($filter)) {
                                            echo "<option value='" . $r['category_id'] . "'>" . $r['category_name'] . "</option>";
                                            //echo $r['category_name'];
                                        }
                                        //$menu = "</select>";
                                        echo "</select>";
                                    } else {
                                        $selected_category = "";
                                        $category_id = "";
                                        $sql = "select category_id from post_category WHERE post_id='" . $post_id . "'";
                                        $res = $con->query($sql);
                                        if (mysqli_num_rows($res) > 0) {
                                            $row = mysqli_fetch_array($res);
                                            $category_id = $row['category_id'];
                                        }
                                        $categoryIdWhereSetSelected = $category_id;
                                        $sqlcat = "select category_name from category WHERE category_id='" . $category_id . "'";
                                        $res = $con->query($sqlcat);
                                        if (mysqli_num_rows($res) > 0) {
                                            $setSelected = true;
                                            ?>
                                            <input type="hidden" name="isSetSelected" value="yesCat">
                                            <?php
                                            $row = mysqli_fetch_array($res);
                                            $selected_category = $row['category_name'];
                                            //echo $selected_category;
                                            $sqlcat = "select * from category";
                                            $filter = $con->query($sqlcat);
                                            //$menu = "";
                                            echo "<select name=\"category_id\" id=\"category_id\">";
                                            echo "<option selected='selected' value='" . $categoryIdWhereSetSelected . "'>" . $selected_category . "</option>";
                                            while ($r = mysqli_fetch_array($filter)) {
                                                echo "<option value='" . $r['category_id'] . "'>" . $r['category_name'] . "</option>";
                                                //echo "<option selected='selected'>". $selected_category . "</option>";
                                                //echo $r['category_name'];
                                            }
                                            //$menu = "</select>";
                                            echo "</select>";
                                            //echo $post_id;
                                            //echo " ".$category_id." ".$categoryIdWhereSetSelected;
                                        } else {
                                            echo "No Category";
                                            ?>
                                            <input type="hidden" name="isSetSelected" value="noCat">
                                            <?php
                                            $setSelected = false;
                                            $categoryIdWhereSetSelected = 0;
                                            $sql = "select * from category";
                                            $filter = $con->query($sql);
                                            //$menu = "";
                                            echo "<select name=\"category_id\" id=\"category_id\">";
                                            while ($r = mysqli_fetch_array($filter)) {
                                                echo "<option value='" . $r['category_id'] . "'>" . $r['category_name'] . "</option>";
                                                //echo $r['category_name'];
                                            }
                                            //$menu = "</select>";
                                            echo "</select>";
                                            //echo $post_id." ".$categoryIdWhereSetSelected." ".$category_id." "."No cat";

                                        }
                                    }

                                }
                                ?>
                        <br>
                        <p>Tags:</p>
                        <?php if($isUpdate) {
                            $sql="SELECT * FROM tags WHERE post_id='".$post_id2."';";
                            $res=$con->query($sql);

                            if ($res->num_rows > 0) {
                                foreach ($res as $row) {
                                    echo $row['tag_name'].',';
                                    }
                                }
                        }?>
                        <br>
                        <input type="text" size="100" name="tags_txt" placeholder="<?php if($isUpdate) echo "add more tags. tags will be comma separated."; else echo "tags will be comma separated.";?>">
                        <br>
                            <input type="submit" name="submit_btn" class="regsubmit" value= <?php if ($isUpdate) {?> "Update" <?php } else {?> "Save" <?php } ?> >
                    </form>
                </div>
        </div>
    </div>
</body>
</html>
<?php $con->close(); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    
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
