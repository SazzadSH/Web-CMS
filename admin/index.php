<?php
    session_start();
    //echo $_GET['id'];
    if(isset($_GET['id']) && $_GET['id']=='logout'){
        session_destroy();
        ?>

<?php

    }
    else if(isset($_SESSION['username'])){//header("location:dashboard.php");
      //  echo $_GET['id'];?>


        <?php
        echo $_SESSION['username'];
        header("location:dashboard.php");
    }
    //if(isset($_get['id'])){session_destroy();}
    //else{header("location:dashboard.php");}
    //echo $_SESSION['username'];

    //if(isset($_SESSION['username'])) header("location:index.php");
    //else echo "nai";
?>
<html>
  <body>
	<form action="validate.php" method="post">
		<table align='center' height="600" width="300">
		<tr>
			<td>
				<fieldset>
					
					<legend>Login:</legend>
					<table>
						<tr>
							<td>User Name:</td>
							<td><input type="text" name="username"/></td>
						</tr>
						<tr> </tr>
						<tr>
							<td>Password:</td>
							<td><input type="password" name="password"/></td>
						</tr>
					
					</table>
					<hr>
					<input type="checkbox" name="remember" value="remember"/>Remember Me<br><br>
					<input type="submit" value="Submit" name="SubmitLogin"/>
					<a href="email.php">Forget Password?</a>&nbsp <a href="registration.php">Registration</a>
							
					
				</fieldset>
			</td>
		</tr>
	
	
		</table>
	</form>
  </body>
  
</html>
