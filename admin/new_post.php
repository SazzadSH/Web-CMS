<?php session_start();
if(!isset($_SESSION['username'])) header("location:index.php");
$username=$_SESSION['username'];
//echo $username;
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
                                            $sql = "INSERT INTO tags (tag_name, post_id) VALUES ('" . $tag . "','" . $post_id . "');";
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
                                header("location:post.php");
                            }
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
                                    echo " first for loop e dhukse ";
                                    $tag = trim($ar[$i]);
                                    if (!empty($tag)) {
                                        //echo " tag empty na ";
                                        if ($res->num_rows > 0) {
                                            foreach ($res as $row) {
                                                if ($tag == $row['tag_name']) {
                                                    echo $row['tag_name'].'<br>';
                                                    $tagNew = false;
                                                    break;
                                                }
                                                else {
                                                    $tagNew=true;
                                                }
                                            }
                                        }
                                        if (preg_match("/^[a-zA-Z0-9_]+$/", $tag)) {

                                            echo " preg match korse ".$post_id2." ";
                                            if(!$tagNew){echo "tag new false"; continue;} else echo " tag new true ";
                                            $sql = "INSERT INTO tags (tag_name, post_id) VALUES ('" . $tag . "','" . $post_id2 . "');";
                                            if ($con->query($sql)) {
                                                echo " tag success ";
                                                $checkUpdate = true;
                                            }
                                            else {
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
                                header("location:post.php");
                            }
                            else echo "tag update hoy nai";
                        }
                    }

            }

            $con->close();
        }


    ?>


    <div class="wrapper" style="height: auto">
        <div class="topbar">
            
        </div>
        <div class="main">
        <div class="sidebar">
                <ul>
                    <li>
                        <a href="post.php">Post</a>
                        <ul>
                            <li><a href="post.php">All Post</a></li>
                            <li><a href="new_post.php">New Post</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="pages.php">Pages</a>
                        <ul>
                             <li><a href="pages.php">All Pages</a></li>
                            <li><a href="new_pages.php">New Page</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="comment.php">Comments</a>
                    </li>
                    <li>
                        <a href="profile.php">Profile</a>
                    </li>
					<li>
                        <a href="index.php?id=logout">Logout!</a>
                    </li>
                </ul>
            </div>
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
                    $sql = "SELECT * FROM posts p WHERE user_id='" . $user_id . "' AND is_active=1 AND post_id='" . $post_id . "';";
                    $res = $con->query($sql);
                    if (mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_array($res);
                    } else {
                        echo "username doesn't match" . '<br>' . $con->error;
                    }
                }

                $con->close();
            }
            //if(isset($_GET['post_id'])){
                ?>
                <div class="main_content">
                    <form method="POST">
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
                                            echo $r['category_name'];
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
                                            echo $selected_category;
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
                                            echo $post_id;
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
                                                echo $r['category_name'];
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
                            <input type="submit" name="submit_btn" value= <?php if ($isUpdate) {?> "Update" <?php } else {?> "Save" <?php } ?> >
                    </form>
                </div>
        </div>
    </div>
</body>
</html>
<?php $con->close(); ?>