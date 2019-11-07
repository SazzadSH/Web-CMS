<?php session_start();
if(!isset($_SESSION['username'])) header("location:index.php");
$username=$_SESSION['username']; ?>

<?php
    $con=mysqli_connect("localhost","root","","blog_cms");
    if(mysqli_connect_error()){
        echo "Failed to connect to mysql: ".mysqli_connect_error();
    }
    else{
        $user_id=0;
        $sql2 = "SELECT user_id FROM users WHERE username='" . $username . "';";
        $res = mysqli_query($con, $sql2);
        if (mysqli_num_rows($res) > 0) {
            $row1 = mysqli_fetch_array($res);
            $user_id = $row1['user_id'];
        } else {
            echo "username doesn't exist." . '<br>' . $con->error;
        }
        $sql="SELECT * FROM posts p WHERE user_id='".$user_id."' AND is_active=1";
        $res=$con->query($sql);
    }
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
</head>
<body>
	<?php
        $post_title = $post_body = "";
        $post_time = date("Y-m-d h:i:sa");

        $post_id = fread(fopen("postcount.txt", "r"), filesize("postcount.txt"));
    
        if( isset( $_POST["submit_btn"] ) )
        {
            $post_title = $_POST["title_txt"];
            $post_body = $_POST["post_txt"];
            $username=$_SESSION['username'];
            $created_date = date("Y-m-d h:i:sa");
            $modified_date = date("Y-m-d h:i:sa");
            $user_id="";
            $post_file = fopen("./posts/".$post_id.".txt", "w");
            fwrite($post_file, $post_id."\r\n");
            fwrite($post_file, $post_time."\r\n");
            fwrite($post_file, $post_title."\r\n");
            fwrite($post_file, $post_body);
            fclose($post_file);

            $post_id++;
            fwrite(fopen("postcount.txt", "w"), $post_id);


        }

    ?>




    <div class="wrapper">
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
            <div class="main_content">

            <h1>All Posts</h1>
                <table>

                    <tr>
                        <th>Post Id</th>
                        <th>Post Title</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                    $i=0;
                    if ($res->num_rows > 0) {

                        foreach ($res as $row) {
                            $i++;
                            ?>
                    <tr>

                        <td><?php echo $i;?></td>
                        <td><?php echo $row["title"];?></td>
                        <td><a href="new_post.php?id=<?php echo $row["post_id"];?>">Edit</a></td>
                        <td><a href="delete_post.php?id=<?php echo $row["post_id"];?>">Delete</a></td>
                    </tr>
                    <?php
                    }
                    }
                    else{
                        echo "0 results";
                    }
                    ?>
                </table>

            </div>
        </div>
    </div>
</body>
</html>
<?php $con->close() ?>