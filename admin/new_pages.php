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

    <?php
        $page_title = $page_body = "";
        $page_id;
        $page_time = date("Y-m-d h:i:sa");

        $page_id = fread(fopen("pagecount.txt", "r"), filesize("pagecount.txt"));
    
        if( isset( $_POST["submit_btn"] ) )
        {
            $page_title = $_POST["title_txt"];
            $page_body = $_POST["page_txt"];

            $page_file = fopen("./pages/".$page_id.".txt", "w");
            fwrite($page_file, $page_id."\r\n");
            fwrite($page_file, $page_time."\r\n");
            fwrite($page_file, $page_title."\r\n");
            fwrite($page_file, $page_body);
            fclose($page_file);

            $page_id++;
            fwrite(fopen("postcount.txt", "w"), $page_id);
        }

    ?>


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
                <form action="pages.php" method="POST">
                    <h1>New Page</h1>
                    <p>Title:</p>
                    <input type="text" size="100" name="title_txt" value="<?php echo $page_title; ?>">
                    <p>Page:</p>
                    <td><textarea name="page_txt" style="width:615px; height:500px"><?php echo $page_body; ?></textarea><br />
                    <input type="submit" name="submit_btn" value="Save">
                </form>
            </div>
        </div>
    </div>
</body>
</html>