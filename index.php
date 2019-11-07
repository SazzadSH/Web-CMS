<?php
    $con = mysqli_connect("localhost","root","","blog_cms");

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else{
        $sql = "SELECT * FROM posts WHERE is_active=1;";
        $result = $con->query($sql);
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
                    <div class="dt"><p><?php echo strtok($row["created_date"], ' '); ?></p></div>
                    <div class="cat">
                        <p> <?php
                                $sql="SELECT c.category_name FROM category c, post_category p WHERE c.category_id=p.category_id AND p.post_id='".$row['post_id']."';";
                                //$sql = "SELECT category.category_name FROM category INNER JOIN post_category WHERE post_category.post_id=".$row["post_id"].";";
                                $cat = $con->query($sql);
                                if ($cat->num_rows > 0) {
                                    foreach ($cat as $catT) {
                                        echo $catT['category_name'];
                                    }
                                }else{
                                    echo "No Catagory";
                                }
                            ?>
                        </p>
                    </div>
                    <h3><a href="post.php?id=<?php echo $row["post_id"]; ?>"><?php echo '<br>'.$row["title"] ;?></a></h3>
                </div>
                <div class="postBody"><p><?php echo explode("<div style=\"page-break-after:always\"><span style=\"display:none\">&nbsp;</span></div>",$row['body'])[0]."..." ;?></p>
                </div>
                <div class="postFooter">
                    <a href="post.php?id=<?php echo $row["post_id"]; ?>">READ MORE</a>
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
            </div>
            <?php 
                    }
                }
                else{
                    echo "<div class='posts'><h3>So Empty!!! Create New Post</h3></div></div>";
                } 
            ?>
        </div>
        <?php
            include_once "footer.php"; 
        ?>
    </body>
</html>
