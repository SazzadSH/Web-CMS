<?php

    session_start();
    $user_type_id = $_SESSION['user_type_id'];
    $userId = $_SESSION['user_id'];

    if($user_type_id != 1)
    {
        header("Location: ./");
    }

    $con = mysqli_connect("localhost", "root", "", "blog_cms");

    if(isset($_GET['activate']))
    {
        $uid = $_GET['activate'];

        $sql = "UPDATE users SET is_active=1 WHERE user_id=".$uid;
        $con->query($sql);
    }
    else if(isset($_GET['deactivate']))
    {
        $uid = $_GET['deactivate'];

        $sql = "UPDATE users SET is_active=0 WHERE user_id=".$uid;
        $con->query($sql);
    }
    else if(isset($_GET['chng2admin']))
    {
        $uid = $_GET['chng2admin'];

        $sql = "UPDATE users SET user_type_id=1 WHERE user_id=".$uid;
        $con->query($sql);
    }
    else if(isset($_GET['chng2usr']))
    {
        $uid = $_GET['chng2usr'];

        if($uid == $userId)
        {
            header("Location: ./");
        }

        $sql = "UPDATE users SET user_type_id=2 WHERE user_id=".$uid;
        $con->query($sql);
    }
    else if(isset($_GET['delete']))
    {
        $uid = $_GET['delete'];

        if($uid != $userId)
        {
            $sql = "DELETE FROM users WHERE user_id=".$uid;
            $sql2 = "DELETE FROM persons WHERE user_id=".$uid;
            $con->query($sql);
            $con->query($sql2);
        }
        else
        {
            header("Location: ./");
        }    
    }

    header("Location: ./user_management.php");