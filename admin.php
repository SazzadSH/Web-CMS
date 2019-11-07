<!DOCTYPE html>
<html>
    <head>
        <title>{Title}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <div class="header">
            <div class="headerLeft">
                <h2><a href="#">Hi, {User Name}</a></h2>
            </div>
            <div class="headerRight">
                <div class="logout">
                    <a href="#">Logout</a>
                </div>
            </div>
        </div>
        <div class="adminBody">
            <div class="tabs">
                <div class="tab">
                    <input type="radio" id="tab-1" name="tab-group-1" checked>
                    <label for="tab-1">Posts</label>
                    <div class="content">
                        {posts}
                    </div> 
                </div>
    
                <div class="tab">
                    <input type="radio" id="tab-2" name="tab-group-1">
                    <label for="tab-2">Comments</label>
                    <div class="content">
                        {Comments}
                    </div> 
                </div>

                <div class="tab">
                    <input type="radio" id="tab-3" name="tab-group-1" checked>
                    <label for="tab-3">Pages</label>
                    <div class="content">
                        {pages}
                    </div> 
                </div>
    
                <div class="tab">
                    <input type="radio" id="tab-4" name="tab-group-1">
                    <label for="tab-4">Profile</label>
                    <div class="content">
                        {Profile}
                    </div> 
                </div>
            </div>
        </div>
        <div class="footerAdmin">
            <div class="copyAdmin">
                <p>&copy; 2018 -{Site Name}. All Rights Reserved.</p>
            </div>
        </div>
    </body>
</html>
