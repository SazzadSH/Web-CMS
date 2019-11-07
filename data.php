<?php
	$con=mysqli_connect("localhost","root","","blog_cms");
	if(!$con){
		die("connection failed: ".mysqli_connect_error());
	}
	else{
		$sql="SELECT * FROM posts WHERE title LIKE '%".$_REQUEST["q"]."%';";
		$res=mysqli_query($con,$sql);
		$list="";
		for($i=0;$i<mysqli_num_rows($res);$i++)
		{
			$row[$i]=mysqli_fetch_array($res);
			$list='<li>'.$row[$i]['title'].'</li>';
		}
		if ($list=="") {
  			$response="no suggestion";
		} else {
  			$response="$list";
		}
		echo $response;
	}
?>