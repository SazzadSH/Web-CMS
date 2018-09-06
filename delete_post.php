<?php session_start(); $username= $_SESSION['username'];
//echo $username;
    $post_id=$_GET["id"];
    echo $post_id;

    $con = mysqli_connect("localhost", "root", "", "blog_cms");
    if (!$con) {
        die("error! " . mysqli_connect_error());
    }
    else {
        $sql = "UPDATE posts SET is_active='0'  WHERE post_id='" . $post_id . "'";

        if ($con->query($sql)) {
            echo "success";
            header("location:manage_posts.php");

        }
        else {
            echo "failed: " . $con->error;
        }
    }

    $con->close();
//echo $id;
?>