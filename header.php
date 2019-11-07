<?php
    $con = mysqli_connect("localhost","root","","blog_cms");

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else{
        $sqlSite = "SELECT * FROM site ;";
        $resultSite = $con->query($sqlSite);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php
            if ($resultSite->num_rows > 0) {
                foreach ($resultSite as $site) {
                    echo $site['site_name'];
                }
            }else{
                echo "Site Name";
            }
            ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.js"></script>
    </head>

    <body>
        <div class="header">
            <nav class=" navbar navbar-expand-md">
                <div class="container col-sm-4">
                    <a class="navbar-brand" href="index.php"><h2><?php
                            if ($resultSite->num_rows > 0) {
                                foreach ($resultSite as $site) {
                                    echo $site['site_name'];
                                }
                            }else{
                                echo "Site Name";
                            }
                            ?></h2></a>
                </div>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse ml-auto navigation" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="./admin/index.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="javascript:srch();"><i class="fa fa-search"></i></a></li>
                    </ul>
                </div>
            </nav>
            <div id="srch" class=" navbar navbar-expand-md invisible">
                <form  class=" form-inline my-2 my-lg-0 ml-auto dropdown" method="post" action="search.php">
                    <input class="form-control mr-sm-1" type="search" name="srch" placeholder="Search" aria-label="Search" id="demo" onkeyup="getData(this.value)" data-toggle="dropdown">

                    <button class="btn btn-outline-success my-2 my-sm-0 searchBoxBtn" name="submit_srch" type="submit">Search</button>
                    <ul class="dropdown-menu" id="sugg" role="menu" aria-labelledby="demo"></ul>
                </form>
            </div>
        </div>
        
        <script type="text/javascript">
            function srch(){
                var srch = document.getElementById("srch");
                if(srch.classList.contains("invisible")){
                    srch.classList.remove("invisible");
                    srch.classList.add("visible");
                }else{
                    srch.classList.remove("visible");
                    srch.classList.add("invisible");
                }
            }
            function getData(str) {
                if(str.length==0) {document.getElementById("sugg").innerHTML="empty";}
                else{
                    var xhttp=new XMLHttpRequest();
                    xhttp.onreadystatechange=function(){
                        if(this.readyState==4 && this.status==200) {
                            document.getElementById("sugg").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET","data.php?q="+str,true);
                    xhttp.send();
                }

            }
        </script>
    </body>
</html>
<?php  ?>