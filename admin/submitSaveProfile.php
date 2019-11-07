<?php
    session_start();
    if(isset($_POST['submitSaveProfile']))
    {
        $user_id="";
        $email="";
        $con = mysqli_connect("localhost", "root", "", "blog_cms");
        if (!$con) {
            die("error! " . mysqli_connect_error());
        } else {
            {
                $f=0;
                //echo "connected" . '<br>';
                $username = $_SESSION['username'];
                $name=$_POST['name_txt'];
                $email=$_POST['email_txt'];
                $sql1="UPDATE users SET email='".$email."' WHERE username='".$username."'";
                $sql="SELECT user_id from users WHERE username='".$username."';";
                $res=mysqli_query($con, $sql);
                $user_id='0';
                if(mysqli_num_rows($res)>0){
                    $row=mysqli_fetch_array($res);
                    $user_id=$row['user_id'];
                }
                $sql2="UPDATE persons SET person_name='".$name."' WHERE user_id='".$user_id."'";
                if(mysqli_query($con,$sql1) && mysqli_query($con,$sql2))
                {
                    echo "updated";
                }
                else {
                    echo "fail";
                }
                $con->close();
                header("location:profile.php");
            }
        }
    }
?>