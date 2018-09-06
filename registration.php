<?php
  session_start();
  if(isset($_SESSION['username']))
  {
      header("Location: ./dashboard.php");
  }

  $username = "";
  $email = "";
  $password = "";

  $uname_error = "";
  $email_error = "";
  $password_error = "";

  if(isset($_POST['regSubmit']))
  {

    /*
      Validation Part
    */

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($username) || (strlen($username) < 4))
    {
      $uname_error = "*Username must be at least 4 characters!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $email_error = "*Invalid email address!";
    }

    if(empty($password) || (strlen($password) < 4))
    {
      $password_error = "*Password must be at least 4 chracters!";
    }


    /*
      DB part
    */

    $con = mysqli_connect("localhost", "root", "", "blog_cms");
      $sql = "INSERT INTO users (username, email, password, user_type_id, is_active) VALUES ('".$username."', '".$email."', '".$password."', 2, 0)";
      $sql2 = "select * from users where username='".$username."' or email='".$email."'";
      $reg_error = "";

      if(!$con)
      {
        die("Connection failed: " . mysqli_connect_error());
      }

      $result = mysqli_query($con, $sql2);

      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      if($row['username'] == $username)
      {
        $uname_error = "This username is already taken!";
      }

      if($row['email'] == $email)
      {
        $email_error = "This email is already registered!";
      }

    if($uname_error == "" && $email_error == "" && $password_error == "")
    {
      
      if(mysqli_query($con, $sql))
      {
        header("Location: ./");
        die();
      }
      else
      {
        $reg_error = "Registration Failed! Try again.";
      }
    }

    

  }
  
?>


<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="assets/css/entry-style.css">
  <script type="text/javascript" src="assets/js/entry-script.js"></script>
</head>

  <body>

    <div class="login-page">
      <div class="form">
        <?php 
            if(!empty($reg_error))
            {
              echo "<p class=\"error\">".$reg_error."</p>";
            }
        ?>
        <h2 class="headline">User Registration</h2>
        <form class="login-form" method="post" action="">
          <?php 
            if(!empty($uname_error))
            {
              echo "<p class=\"error\">".$uname_error."</p>";
            }
          ?>
          <input class="textInput" type="text" name="username" value="<?php echo $username; ?>" placeholder="Username"/>
          <?php 
            if(!empty($email_error))
            {
              echo "<p class=\"error\">".$email_error."</p>";
            }
          ?>
          <input class="textInput" type="text" name="email" value="<?php echo $email; ?>" placeholder="Email"/>
          <?php 
            if(!empty($password_error))
            {
              echo "<p class=\"error\">".$password_error."</p>";
            }
          ?>
          <input class="textInput" type="password" name="password" placeholder="Password"/>
          <input type="submit" class="regsubmit" name="regSubmit" value="Sign Up">
          <p class="message">Already registerd? <a href="index.php">Sign In</a></p>
        </form>
      </div>
    </div>

  </body>

</html>
