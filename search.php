<?php
    include_once "header.php";
    $con=mysqli_connect("localhost","root","","blog_cms");
    if(!$con){
        die("connection failed: ".mysqli_connect_error());
    }
    else{
        if(isset($_POST['submit_srch']))
        {
            if(trim($_POST["srch"])!=""){
                $sql="SELECT * FROM posts WHERE title LIKE '%".$_POST["srch"]."%';";
                $res=mysqli_query($con,$sql);
            }
            else
            {
                $sql="SELECT * FROM posts ;";
                $res=mysqli_query($con,$sql);
            }

        }
    }
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="mainBody">
            <div class="result">
                <h3><?php
                    echo $res->num_rows;?> Result(s) Found</h3>
            </div>
            <?php
            if ($res->num_rows > 0) {

            foreach ($res

            as $row) {
            ?>
            <div class="posts">
                <div class="postHead">
                    <div class="dt"><p><?php echo strtok($row["created_date"], ' '); ?></p></div>
                    <div class="cat"><p><?php
                            $sql = "SELECT c.category_name FROM category c, post_category p WHERE c.category_id=p.category_id AND p.post_id='".$row['post_id']."';";
                            $cat = $con->query($sql);
                            if ($cat->num_rows > 0) {
                                foreach ($cat as $catT) {
                                    echo $catT['category_name'];
                                }
                            } else {
                                echo "No Catagory";
                            }
                            ?></p></div>
                    <h3><a href="post.php?id=<?php echo $row["post_id"]; ?>"><?php echo "<br/>".$row["title"]; ?></a></h3>
                </div>
            </div>
                <?php
                }
                }else{
                    echo "0 results";
                }
                ?>
            </div>
        </div>

        <?php
            include_once "footer.php";
        ?>
    </body>
</html>
