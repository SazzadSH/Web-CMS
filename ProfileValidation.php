<?php
	SESSION_START();
	$_SESSION['errorname']="";
	$_SESSION['errordob']="";
	$_SESSION['errorgender']="";
	$_SESSION['errorpass']="";
	
	function updatevalue($value,$value1)
	{
		$servername ="localhost";
		$username 	="root";
		$password 	="";
		$dbname 	="blog_cms";
	
		$conn = mysqli_connect($servername, $username, $password, $dbname);
	
		if(!$conn){
			die("Connection Error!".mysqli_connect_error());
		}
		
		//UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1;

		$sql = "UPDATE persons SET ".$value." = '".$value1."' where user_id = '".$_SESSION['user_id']."'";

		if (mysqli_query($conn, $sql)) {
			//echo "New record created successfully";
		} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
	
	function updatepass($value,$value1)
	{
		$servername ="localhost";
		$username 	="root";
		$password 	="";
		$dbname 	="blog_cms";
	
		$conn = mysqli_connect($servername, $username, $password, $dbname);
	
		if(!$conn){
			die("Connection Error!".mysqli_connect_error());
		}
		
		//UPDATE Customers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1;

		$sql = "UPDATE users SET ".$value." = '".$value1."' where user_id = '".$_SESSION['user_id']."'";

		if (mysqli_query($conn, $sql)) {
			//echo "New record created successfully";
		} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
	
	
	if(isset($_POST['UpdateEdit']))
	{
		$name = trim($_POST['myname']);
		$passw = trim($_SESSION['password']);
		$newpass = trim($_POST['newpassword']);
		$repeatpass = trim($_POST['repeatnewpassword']);
		$gender = trim($_POST['gender']);
		$dob = trim($_POST['mydateofbirth1']);
		
		$recorder=0;
		if(strlen($name)==0)
		{
			$_SESSION['errorname']="Empty Field NAME";
			$recorder++;
		}
		else
		{
			$_SESSION['errorname']="";
			$_SESSION['name'] = $name;
			updatevalue("person_name",$_SESSION['name']);
		}
		if(strlen($newpass)>=8)
		{
			if($newpass!=$repeatpass)
			{
				$_SESSION['errorpass']="Unmatch";
				$recorder++;
			}
			else
			{
				$_SESSION['errorpass']="";
				$_SESSION['password'] = $newpass; 
				updatepass("password",$_SESSION['password']);
			}
		}
		else
		{
			$recorder++;
		}
		$day="";
		$month="";
		$year="";
		$counter=0;
		for($i = 0; $i<strlen($dob);$i++)
		{
			if($dob[$i]=='-')
			{
				$counter++;
			}
			else if($counter==0)
			{
				$year=$year.$dob[$i];
			}
			else if($counter==1)
			{
				$month=$month.$dob[$i];
			}
			else if($counter==2)
			{
				$day = $day.$dob[$i];
			}
		}
		
		$today = date("m.d.Y");
		$currentday="";
		$currentmonth="";
		$currentyear="";
		$counter=0;
		for($i = 0; $i<strlen($today);$i++)
		{
			if($today[$i]=='.')
			{
				$counter++;
			}
			else if($counter==0)
			{
				$currentmonth=$currentmonth.$today[$i];
			}
			else if($counter==1)
			{
				$currentday=$currentday.$today[$i];
			}
			else if($counter==2)
			{
				$currentyear = $currentyear.$today[$i];
			}
		}
		
		echo $currentday.' ';
		echo $currentmonth.' ';
		echo $currentyear.' ';
		
								if($year>$currentyear)
								{
									$_SESSION['errordob'] = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspError Date Of Birth";
									
									$recorder++;
								}
								else if($year==$currentyear)
								{
									if($month>$currentmonth)
									{
										$recorder++;
										$_SESSION['errordob'] = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspError Date Of Birth";
									}
									else if($month==$currentmonth)
									{
										if($day>$currentday)
										{
											$recorder++;
											$_SESSION['errordob'] = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspError Date Of Birth";
										}
										else if($day==$currentday)
										{
											$recorder++;
											$_SESSION['errordob'] = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspError Date Of Birth";
										}
										else
										{
											$_SESSION['errordob'] = "";
											$_SESSION['dob']=$month."-".$day."-".$year;
										}
											
									}
									else
									{
										$_SESSION['errordob'] = "";
										$_SESSION['dob']=$month."-".$day."-".$year;
									}
										
								}
								else
								{
									$_SESSION['errordob'] = "";
									$_SESSION['dob']=$year."-".$month."-".$day;
									updatevalue("date_of_birth",$_SESSION['dob']);
								}
								$_SESSION['gender']=$gender;
								updatevalue("gender",$_SESSION['gender']);
		echo $name;
		echo "\n".$passw;
		echo "\n".$newpass;
		echo "\n".$repeatpass;
		echo "\n".$gender;
		echo "\n".$day;
		echo "\n".$month;
		echo "\n".$year;
		echo $recorder;
		
		$info = explode("/",$_FILES["selected_file"]["type"])[1];
		//echo $info;
		if(isset($info))
		{
			if (!($info == "jpg" || $info == "jpeg" || $info == "png"))
			{
				$_SESSION['path']="jpg,jpeg,png allowed only";
			}
			else
			{
				$filename = $_FILES["selected_file"]["tmp_name"];
				$destination = "upload/" . $_FILES["selected_file"]["name"]; 
    			move_uploaded_file($filename, $destination);
    			$_SESSION['img'] = $destination;
				updatevalue("imagepath",$_SESSION['img']);
			}
		}
		else
		{
			$_SESSION['path']= "Please select an image file";
		}
		
		
		
		header("Location:Profile.php");
		
	}
	else
	{
		echo "ERROR 420";
	}
?>
