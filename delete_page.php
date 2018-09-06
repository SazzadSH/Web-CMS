<?php session_start(); $username= $_SESSION['username'];
    $page_id=$_GET["id"];
    
    $con = mysqli_connect("localhost", "root", "", "blog_cms");
    if (!$con) {
        die("error! " . mysqli_connect_error());
    }
    else {
        $sql = "UPDATE pages SET is_active='0'  WHERE page_id='" . $page_id . "'";

        if ($con->query($sql)) {
            echo "success";
            header("location:page.php");

        }
        else {
            echo "failed: " . $con->error;
        }
    }

    $con->close();
?>