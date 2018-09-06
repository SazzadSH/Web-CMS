<?php
    session_start();
    $user_type_id = $_SESSION['user_type_id'];

    if($user_type_id != 1 || $user_type_id != 2)
    {
        header("Location: ./");
    }
    
    $con = mysqli_connect("localhost", "root", "", "blog_cms");

    if(isset($_GET['approve']))
    {
        $pid = $_GET['approve'];
        $cmntOpSQL = "UPDATE comments SET is_approved=1 WHERE comment_id=".$pid;
        $comRes=$con->query($cmntOpSQL);
    }
    else if(isset($_GET['unapprove']))
    {
        $pid = $_GET['unapprove'];

        $cmntOpSQL = "UPDATE comments SET is_approved=0 WHERE comment_id=".$pid;
        $comRes=$con->query($cmntOpSQL);
    }
    else if(isset($_GET['remove']))
    {
        $pid = $_GET['remove'];

        $cmntOpSQL = "UPDATE comments SET is_active=0, is_approved=0 WHERE comment_id=".$pid;
        $comRes=$con->query($cmntOpSQL);
    }
    else if(isset($_GET['delete']) && $user_type_id == 1)
    {
        $pid = $_GET['delete'];

        $cmntOpSQL = "DELETE FROM comments WHERE comment_id=".$pid;
        $con->query($cmntOpSQL);
    }

    header("Location: ./comments.php");