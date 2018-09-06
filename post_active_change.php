<?php session_start();
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];
$user_type_id = $_SESSION['user_type_id'];
$imgpath = "assets/images/icon/avatar-01.jpg";
if($user_type_id!=1) {
    header("location:dashboard.php");
    echo $user_type_id;
}
//echo $username;
else{
    if (isset($_GET['id'])){
        $post_id=$_GET["id"];
    }


    echo $post_id;

    $con = mysqli_connect("localhost", "root", "", "blog_cms");
    if (!$con) {
        die("error! " . mysqli_connect_error());
    }
    else {
        $sqlIsActive="SELECT * from posts WHERE post_id='".$post_id."';";
        $res=$con->query($sqlIsActive);
        if($res->num_rows > 0){
            $row=mysqli_fetch_array($res);

        }
        else{
            echo "row nai";
        }
        if($row['is_active']==1){
            $sql = "UPDATE posts SET is_active='0'  WHERE post_id='" . $post_id . "'";
        }
        else if($row['is_active']==0){
            $sql = "UPDATE posts SET is_active='1'  WHERE post_id='" . $post_id . "'";
        }



        if ($con->query($sql)) {
            echo "success";
            header("location:manage_posts.php");

        }
        else {
            echo "failed: " . $con->error;
        }
    }

    $con->close();

}//echo $id;
?>