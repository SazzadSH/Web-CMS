<?php
    session_start();

	$lsuccess = 0;
	$recoder=0;
	
	if(isset($_POST['SubmitRegistration']))
	{
		$name=$_POST['name'];
		if(!empty($name))
		{
			 $namelength=strlen($name);
			if($namelength>=2)
			{
			$lengthcounter=0;
			for($i=0;$i<$namelength;$i++)
			{
				if(($name[$i]>='A' && $name[$i]<='Z') || ($name[$i]>='a' && $name[$i]<='z') || $name[$i]==' ' || $name[$i]=='-')
				{
					$lengthcounter++;
				}
				else
				{
					break;
				}
			}
			if($lengthcounter!=$namelength)
			{
				echo "Name Formet Error".'<br>';
				$recoder++;
			}
			}
			else
			{
				$recoder++;
			}
		}
		else
		{
			$recoder++;
		}
		
		
		
		
		$email=$_POST['email'];
		$emaillength=strlen($email);
		$lengthcounter=0;
		if(!empty($email))
		{
			$recorder=0;
			$counter=0;
			for($i=0;$i<$emaillength;$i++)
			{
				if($email[$i]=='@' && $recorder==0)
				{
					$counter++;
					$recorder=1;
				}
				else if($email[$i]=='.' && $recorder==1)
				{
					$counter++;
					$recorder=2;
					break;
				}
			}
			if($counter!=2)
			{
				echo "Email Formation Error".'<br>';
				$recoder++;
			}
		}
		else
			$recoder++;
		
		
		
		//user name.
		$checkuser=0;
		$checkpass=0;
		if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confirmpassword']))
		{
			$length=strlen($_POST['username']);
			if($length>=2)
			{
				$string=$_POST['username'];
			for($i=0;$i<$length;$i++)
			{
				if(($string[$i]>='0' && $string[$i]<='9') || ($string[$i]>='A' && $string[$i]<='Z') || ($string[$i]>='a' && $string[$i]<='z'))
				{
					$checkuser++;
				}
				else if($string[$i]=='-' || $string[$i]=='_')
				{
					$checkuser++;
				}
			}
			}	
			
			
			$length1=strlen($_POST['password']);
			if($length1>=8)
			{
				$string=$_POST['password'];
				$confirmpass=$_POST['confirmpassword'];
				for($i=0;$i<$length1;$i++)
				{
					/*(@, #, $, %)*/
					if($string[$i]=='@' || $string[$i]=='#' || $string[$i]=='$' || $string[$i]=='%')
					{
						$checkpass++;
						break;
					}
				}
				if($checkpass==1)
				{
					if($string!=$confirmpass)
					{
						$checkpass=0;
					}
				}
			}
			
			if($length!=$checkuser || $length1<8 || $checkpass==0)
			{
				$recoder++;
				if($length!=$checkuser)
				echo 'Error Username Formation'.'<br>';
				if($length1<8 || $checkpass==0)
				echo 'Error Password Formation'.'<br>';
			}
			
		}
		else if(empty($_POST['username']))
		{
			$recoder++;
			echo 'Username empty'.'<br>';
		}
		else if(empty($_POST['password']))
		{
			$recoder++;
			echo 'Password empty'.'<br>';
		}	
		else if(empty($_POST['confirmpassword']))
		{
			$recoder++;
			echo 'Confirm Password empty'.'<br>';
		}
		
		
		if(!empty($_POST['dd']) && !empty($_POST['mm']) && !empty($_POST['yyyy']))
		{
			$var=0;
			if($_POST['dd']>=1 && $_POST['dd']<=31)
			{
				$var++;
			}
			if($_POST['mm']>=1 && $_POST['mm']<=12)
			{
				$var++;
			}
			if($_POST['yyyy']>=1953 && $_POST['yyyy']<=1998)
			{
				$var++;
			}
			if($var!=3)
			{
				$recoder++;
				echo "Please Provide Valid detail of Date of Birth if You are 1953 to 1998";
			}
			
		}
		
		else if(empty($_POST['dd']))
		{
			$recoder++;
			echo 'Day Field empty'.'<br>';
		}
		else if(empty($_POST['mm']))
		{
			$recoder++;
			echo 'Month Field empty'.'<br>';
		}	
		else if(empty($_POST['yyyy']))
		{
			$recoder++;
			echo 'Year Field empty'.'<br>';
		}
		
		
		
		if($recoder==0)
		{
			$user=$_POST['username'];
			$useremail=$_POST['email'];
			$myfile=fopen("password.txt","r");
			$counters=0;
			$valid1=0;
			$valid2=0;
			while(!feof($myfile))
			{
				$full= fgets($myfile);
				$length=strlen($full);
				$username="";
				$password="";
				$email="";
				$counter=0;
				for($i=0;$i<$length;$i++)
				{
					if($full[$i]==" ")
					{
						$counter++;
					}
					else if($counter==0)
					{
						$username=$username.$full[$i];
					}
					else if($counter==1)
					{
						$password=$password.$full[$i];
					}
					else if($counter==2)
					{
						$email=$email.$full[$i];
					}
				}
				if($username==$user)
				{
					$counters++;
					$valid1=1;
					break;
				}
			}
			fclose($myfile);
			$myfile=fopen("password.txt","r");
			while(!feof($myfile))
			{
				$full= fgets($myfile);
				$length=strlen($full);
				$username="";
				$password="";
				$email="";
				$counter=0;
				for($i=0;$i<$length;$i++)
				{
					if($full[$i]==" ")
					{
						$counter++;
					}
					else if($counter==0)
					{
						$username=$username.$full[$i];
					}
					else if($counter==1)
					{
						$password=$password.$full[$i];
					}
					else if($counter==2)
					{
						$email=$email.$full[$i];
					}
				}
				if(trim($email)==trim($useremail))
				{
					$counters++;
					$valid2=1;
					break;
				}
			}				
			fclose($myfile);
			if($counters==0)
			{
				$myfile=fopen("password.txt","a+");
				$myfile1=fopen("registrationdetail.txt","a+");

				/*insert into database*/
                $con = mysqli_connect("localhost","root","","blog_cms");
                if(!$con){
                    die("error! ".mysqli_connect_error());
                }
                else{
                	echo "connected";
                	$username=$_POST['username'];
                	$email=$_POST['email'];
                	$password=$_POST['password'];
                	$user_type_id=2;
                	$is_active=1;
                	$name=$_POST['name'];
                	$yyyy=$_POST['yyyy'];
                	$mm=$_POST['mm'];
                	$dd=$_POST['dd'];
                	$date_of_birth=$yyyy.'-'.$mm.'-'.$dd;
                	$gender=$_POST['gender'];
                	$imagepath=null;
                    $user_id=0;
                	$sql1="INSERT INTO users (username, email, password, user_type_id, is_active) VALUES ('".$username."', '".$email."', '".$password."', '".$user_type_id."', '".$is_active."' );";

                    if($con->query($sql1)){
                        echo "sql1 inserted into db successfully".'<br>';
                    }
                    else{
                        echo "failed: ".$con->error;
                    }


                	$sql2="SELECT user_id FROM users WHERE username='".$username."';";
                    $res=mysqli_query($con, $sql2);
                    if(mysqli_num_rows($res)>0){
                        $row=mysqli_fetch_array($res);
                        $user_id=$row[$user_id];
                        echo "userid successfully retrieved sql2";
                    }
                    else{
                        echo "username doesn't exist sql2".'<br>'.$con->error;
                    }



                    $sql3="INSERT INTO persons (person_name, gender, date_of_birth, imagepath, user_id) VALUES ('".$name."', '".$gender."', '".$date_of_birth."', '".$imagepath."', '".$user_id."' );";
                    if($con->query($sql3)){
                        echo "sql3 inserted into db successfully".'<br>';

                    }
                    else{
                        echo "failed: ".$con->error;
                    }
                    $con->close();
				}
				/*database done*/

				echo "Successfully Registered.".'<br>';
				$dd=trim($_POST['dd']);
				$mm=trim($_POST['mm']);
				$yyyy=trim($_POST['yyyy']);
				$input=trim($_POST['username'])." ".trim($_POST['name'])." ".$dd."/".$mm."/".$yyyy;
				
				$input=$input."\r\n";
				fwrite($myfile1,$input);
				$input1=trim($_POST['username'])." ".trim($_POST['password'])." ".trim($_POST['email']);
				
				$input1=$input1."\r\n";
				fwrite($myfile,$input1);
				fclose($myfile);
				fclose($myfile1);
				include 'index.php';
			}
			else
			{
				if($valid1==1 && $valid2==1)
				echo "CHANGE Username or Email, ALREADY CREATED";
				else if($valid1==1)
				echo "CHANGE Username, ALREADY CREATED";
				else if($valid2==1)
				echo "CHANGE Email, ALREADY CREATED";
				include 'registration.php';
			}
		}
		
	}
	else if(isset($_POST['SubmitLogin'])) {
        $con = mysqli_connect("localhost", "root", "", "blog_cms");
        if (!$con) {
            die("error! " . mysqli_connect_error());
        } else {
        	while (1){

                //echo "connected" . '<br>';
                $username = $_POST['username'];
                $password = $_POST['password'];
                $sql = "select * from users where username='" . $username . "' and password='" . $password . "';";
                $sql2="SELECT user_id FROM users WHERE username='".$username."';";
                $res=mysqli_query($con, $sql2);
                if(mysqli_num_rows($res)>0){
                    $row1=mysqli_fetch_array($res);
                    $user_id=$row1['user_id'];
                }
                else{
                    echo "username doesn't exist.".'<br>'.$con->error;
                    break;
                }
                $res = mysqli_query($con, $sql);
                if (mysqli_num_rows($res) > 0) {

                    $row = mysqli_fetch_array($res);
                    echo "Welcome, " . $row['username'];
                    $_SESSION['username']=$_POST['username'];
                    $counter1 = 1;
                    echo "Successfully Login";
                    //header('loaction: http://localhost:8082/wtproject/admin/dashboard.php');

                    header("location:dashboard.php");
                    $lsuccess = 1;

                }
                else {
                    echo "username or password doesn't match" . '<br>' . $con->error;
                    break;
                }
                $con->close();
			}

            /*$var=0;
            $var1=0;
            if(!empty($_POST['username']) || !empty($_POST['password']))
            {
                $length=strlen($_POST['username']);
                if($length>=2)
                {
                    $string=$_POST['username'];
                for($i=0;$i<$length;$i++)
                {
                    if(($string[$i]>='0' && $string[$i]<='9') || ($string[$i]>='A' && $string[$i]<='Z') || ($string[$i]>='a' && $string[$i]<='z'))
                    {
                        $var++;
                    }
                    else if($string[$i]=='-' || $string[$i]=='_')
                    {
                        $var++;
                    }
                }
                }


                $length1=strlen($_POST['password']);
                if($length1>=8)
                {
                    $string=$_POST['password'];
                for($i=0;$i<$length1;$i++)
                {
                    /*(@, #, $, %)*//*
				if($string[$i]=='@' || $string[$i]=='#' || $string[$i]=='$' || $string[$i]=='%')
				{
					$var1++;
					break;
				}
			}
			}
			
			if($length!=$var || $length1<8 || $var1==0)
			{
				echo 'Error Username or Password Formation';
				include 'index.php';
			}
			else
			{
				$myfile=fopen("password.txt","r");
				$name=$_POST['username'];
				$pass=$_POST['password'];
				$counter1=0;
				
				while(!feof($myfile))
				{
					$full= fgets($myfile);
					$length=strlen($full);
					$username='';
					$password='';
					$counter=0;
					for($i=0;$i<$length;$i++)
					{
						if($full[$i]=="\n")
								continue;
						if($full[$i]==' ')
						{
							$counter++;
						}
						else if($counter==0)
						{
							$username=$username.$full[$i];
						}
						else if($counter==1)
						{
							$password=$password.$full[$i];
						}
					}
					$username=trim($username);
					$password=trim($password);
					if($username==$name)
					{
						if($pass==$password)
						{
							$counter1=1;
							echo "Successfully Login";
							//header('loaction: http://localhost:8082/wtproject/admin/dashboard.php');
							
							include 'dashboard.php';
							$lsuccess = 1;
							break;
						}
						else
						{
							break;
						}
						
					}
				}
				if($counter1==0)
				{
					echo "Check Username or Password";
					include 'index.php';
				}
				fclose($myfile);
			}
				
			
		}
		else
			echo 'Must Atleast 2 Characters.';*/

        }
    }
	
	else if(isset($_POST['Submitforgetpassword']))
	{
		$old=$_POST['oldpass'];
		$new=$_POST['newpass'];
		$newmatch=$_POST['newmatchpass'];
		if($old!=$new)
		{
			if($new==$newmatch)
			{
				echo "Password Successfully Changed.";
			}
			else
				echo "YOUR NEW Password Cannot MATCH";
		}
		else
			echo "YOU NEW Password LOOKS LIKE A OLD ONE";
	}
	
	else if(isset($_POST['SubmitEmail']))
	{
		$useremail = $_POST['email'];
		$counters=0;
		$myfile=fopen("password.txt","r");
		while(!feof($myfile))
			{
				$full= fgets($myfile);
				$length=strlen($full);
				$username="";
				$password="";
				$email="";
				$counter=0;
				for($i=0;$i<$length;$i++)
				{
					if($full[$i]==" ")
					{
						$counter++;
					}
					else if($counter==0)
					{
						$username=$username.$full[$i];
					}
					else if($counter==1)
					{
						$password=$password.$full[$i];
					}
					else if($counter==2)
					{
						$email=$email.$full[$i];
					}
				}
				$email=trim($email);
				$useremail=trim($useremail);
				if($email==$useremail)
				{
					$counters++;
					break;
				}
			}
			if($counters==1)
			{
				echo "Successfully Send Username and random generate Password to Your Email";
			}
			else
				echo "Not Registered Email.";
			
			fclose($myfile);			
	}
	
	else
		echo "ERROR";


?>
