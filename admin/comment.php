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
            <h1>All Comments</h1>
                <table>
                    <tr>
                        <th>Comment Id</th>
                        <th>Comments</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>00</td>
                        <td>Sample Comment</td>
                        <td><a href="#">Edit</a></td>
                        <td><a href="#">Delete</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>