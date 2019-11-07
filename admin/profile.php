<?php
    session_start();
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
                <form action="submitSaveProfile.php" method="post">
                <p>Name: </p>
                <input type="text" name="name_txt" value="<?php if(isset($_SESSION['username'])){echo getName();} else{echo "no user is found";} ?>"  size="20">
                <p>Username: </p>
                <input type="text" name="username_txt" value="<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];} else{echo "no username is found";} ?>" size="20" readonly>
                <p>Email Address: </p>
                <input type="text" name="email_txt" value="<?php if(isset($_SESSION['username'])){echo getEmail();} else{echo "no user is found";} ?>" size="20"><br />
                <input type="submit" value="Save" name="submitSaveProfile">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    function getEmail()
    {
        $user_id="";
        $email="";
        $con = mysqli_connect("localhost", "root", "", "blog_cms");
        if (!$con) {
            die("error! " . mysqli_connect_error());
        } else {
            {

                //echo "connected" . '<br>';
                $username = $_SESSION['username'];
                //$sql = "select * from users where username='" . $username . "' and password='" . $password . "';";
                $sql2 = "SELECT * FROM users WHERE username='" . $username . "';";

                $res = mysqli_query($con, $sql2);
                if (mysqli_num_rows($res) > 0) {
                    $row1 = mysqli_fetch_array($res);

                    $email=$row1['email'];
                }
                else {
                    echo "username doesn't exist." . '<br>' . $con->error;

                }
                $con->close();
            }
        }
        return $email;
    }
    function getName()
    {
        $name = "";

        $con = mysqli_connect("localhost", "root", "", "blog_cms");
        if (!$con) {
            die("error! " . mysqli_connect_error());
        } else {
            {
                $name="";
                $username=$_SESSION['username'];
                $sql="select p.person_name FROM persons p, users u WHERE p.user_id=u.user_id and u.username='".$username."';";
                $res = mysqli_query($con, $sql);
                if (mysqli_num_rows($res) > 0) {

                    $row = mysqli_fetch_array($res);
                    $name = $row['person_name'];
                    return $name;
                }
                else {
                    $name="nai";
                    echo "username doesn't exist." . '<br>' . $con->error;

                }
            }
        }
        return $name;
    }
?>