<?php
  session_start();
?>

<?php

  if(isset($_SESSION['username']))
  {
      header("Location: ./dashboard.php");
  }

  $username = "";
  $password = "";
  $uname_error = "";
  $password_error = "";
  $login_error = "";

  if(isset($_POST['logSubmit']))
  {
      $username = $_POST['username'];
      $password = $_POST['password'];

      if(empty($username) || (strlen($username) < 4))
      {
          $uname_error = "Invalid Username!";
      }

      if(empty($password) || (strlen($password) < 4))
      {
          $password_error = "Invalid Password";
      }

      

      if($uname_error == "" && $password_error == "")
      {
          $sql = "select user_id, username, email, password, user_type_id, is_active from users where username='".$username."'"; 
          $con = mysqli_connect("localhost", "root", "", "blog_cms");

          if(!$con)
          {
              die("Connection failed: " . mysqli_connect_error());
          }

          $result = mysqli_query($con, $sql);

          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

          if($row['username'] != $username)
          {
              $uname_error = "Username is not registered!";
              $username = "";
          }
          else if($row['password'] != $password)
          {
              $password_error = "Password did not match!";
          }
          else if($row['username'] == $username && $row['password'] == $password)
          {
              $_SESSION['username'] = $username;
              $_SESSION['user_id'] = $row['user_id'];
              $_SESSION['email'] = $row['email'];
              $_SESSION['user_type_id'] = $row['user_type_id'];
              $_SESSION['is_active'] = $row['is_active'];

              if(isset($_POST['remember']))
              {
                  setcookie("username", $username, time()+(60*60*24*7));
                  setcookie("password", $password, time()+(60*60*24*7));
              }
              else
              {
                  setcookie("username", "");
                  setcookie("password", "");
              }
              header("Location: ./dashboard.php");
          }
          else
          {
              $login_error = "Login Failed! Try again.";
          }
      }
  }
  else if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
  {
      $username = $_COOKIE['username'];
      $password = $_COOKIE['password'];

      if($username != "" && $password != "")
      {
          $sql = "select user_id, username, email, password, user_type_id, is_active from users where username='".$username."'"; 
          $con = mysqli_connect("localhost", "root", "", "blog_cms");

          $result = mysqli_query($con, $sql);

          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);


          $_SESSION['username'] = $username;
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['user_type_id'] = $row['user_type_id'];
          $_SESSION['is_active'] = $row['is_active'];

          header("Location: ./dashboard.php");
      }
  }

  

  if(isset($_GET['active']) && $_GET['active'] == 0)
  {
      $login_error = "User account is not activated!";   
  }

?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/entry-style.css">
</head>

  <body>

    <div class="login-page">
      <div class="form">
        <?php 
            if(!empty($login_error))
            {
              echo "<p class=\"error\">".$login_error."</p>";
            }
        ?>
        <h2 class="headline">Login Panel</h2>
        <form class="login-form" method="POST" action="">
          <?php 
            if(!empty($uname_error))
            {
              echo "<p class=\"error\">".$uname_error."</p>";
            }
          ?>
          <input class="textInput" name="username" value="<?php echo $username; ?>" type="text" placeholder="Username"/>
          <?php 
            if(!empty($password_error))
            {
              echo "<p class=\"error\">".$password_error."</p>";
            }
          ?>
          <input class="textInput" name="password" type="password" placeholder="Password"/>
          <input type="checkbox" name="remember" value="1"> Remember Me<br>
          <input type="submit" class="regsubmit" name="logSubmit" value="Sign Up">
          <p class="message">Not registered? <a href="registration.php">Create an account</a></p>
        </form>
      </div>
    </div>

  </body>

</html>