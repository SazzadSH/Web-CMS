<?php
    if(isset($_GET['id'])){
        $con = mysqli_connect("localhost","root","","blog_cms");

        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else{
            $sql = "SELECT * FROM posts WHERE post_id=".$_GET['id'].";";
            $result = $con->query($sql);
        }
    }else{
        header("Location:index.php");
        exit();
    }
    include_once "header.php";
?>

<!DOCTYPE html>
<html>
    <body>

        <div class="mainBody">
            <?php 
                if ($result->num_rows > 0) {
                    foreach ($result as $row) {
            ?>
            <div class="posts">
                <div class="postHead">
                    <div class="dt"><p><?php echo strtok($row["created_date"], ' ');?> by
                        <?php 
                            $sqlAuthor = "SELECT * FROM users WHERE user_id=".$row["user_id"].";";
                            $resultAuthor = $con->query($sqlAuthor);
                            if ($resultAuthor->num_rows > 0) {
                                foreach ($resultAuthor as $author) { 
                                    echo $author["username"];
                                }
                            }
                         ?>
                           
                        </p>
                    </div>
                    <div class="cat"><p><?php
                                $sql = "SELECT c.category_name FROM category c, post_category p WHERE c.category_id=p.category_id AND p.post_id='".$row['post_id']."';";
                                $cat = $con->query($sql);
                                if ($cat->num_rows > 0) {
                                    foreach ($cat as $catT) {
                                        echo $catT['category_name'];
                                    }
                                }else{
                                    echo "No Catagory";
                                }
                            ?></p></div>
                    <h3><?php echo $row["title"]; ?></h3>
                </div>
                <div class="postBody"><p><?php echo $row["body"]; ?></p></div>
                <?php 
                    }
                }
                else{
                    echo "0 results";
                } 
            ?>
                <div class="postFooter">
                    <div class="share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/cms/post.php?id=<?php echo $_GET['id']?>"><i class="fa fa-facebook-official"></i></a>
                        <a href="https://plus.google.com/share?url=http://localhost/cms/post.php?id=<?php echo $_GET['id']?>"><i class="fa fa-google-plus-square"></i></a>
                        <a href="http://www.twitter.com/share?url=http://localhost/cms/post.php?id=<?php echo $_GET['id']?>"><i class="fa fa-twitter-square"></i></a>
                    </div>
                    <p>
                        <?php
                            $sql = "SELECT tag_name FROM tags WHERE post_id=".$row["post_id"].";";
                            $tag = $con->query($sql);
                            if ($tag->num_rows > 0) {
                                foreach ($tag as $tagT) {
                                    echo $tagT['tag_name']." ";
                                }
                            }else{
                                echo "No Tags";
                            }
                            ?>
                    </p>
                </div>
                <?php include_once "comment.php"?>
            </div>
        </div>
        <?php
            include_once "footer.php"; 
        ?>
    </body>
</html>
