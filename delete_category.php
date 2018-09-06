<?php session_start();
if(!isset($_SESSION['username'])) header("location:index.php");
$username= $_SESSION['username'];

//echo $username;
$category_id=$_GET["id"];
echo $category_id;

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



    $sql = "delete from post_category WHERE category_id='".$category_id."'";

    if ($con->query($sql)) {
        echo "success";
        $sql="delete from category WHERE category_id='".$category_id."'";

        if ($con->query($sql)) {
            echo "success";
            header("location:category_admin.php");

        }
        else {
            echo "failed: " . $con->error;
        }
    }
    else {
        echo "failed: " . $con->error;
    }
}

$con->close();
//echo $id;
?>