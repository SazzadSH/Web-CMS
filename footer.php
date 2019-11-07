
    <div class="container-fluid footer">
        <div class="footerSite">
            <h3><?php
                if ($resultSite->num_rows > 0) {
                    foreach ($resultSite as $site) {
                        echo $site['site_name'];
                    }
                }else{
                    echo "Site Name";
                }
                ?></h3>
    	</div>
        <div class="copy">

            <p>&copy;
                <?php
                if ($resultSite->num_rows > 0) {
                    foreach ($resultSite as $site) {
                        echo strtok($site['site_create_date'], '-')."-". $site['site_name'];
                    }
                }else{
                    echo "Site Name";
                }
                ?>. All Rights Reserved.</p>
        </div>
    </div>
