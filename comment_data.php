<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo '<script language="javascript">';
    echo 'alert("Entering Logic")';
    echo '</script>';
    $counter = 0;
    if (isset($_POST['submitComment'])) {
        if ($_POST["name"] != "") {
            if (ctype_alpha($_POST["name"][0])) {
                if (substr_count(trim($_POST["name"]), ' ') > 0) {
                    if (ctype_alpha(str_replace('-', '', str_replace(' ', '', $_POST["name"]))) === false) {
                        echo '<script language="javascript">';
                        echo 'alert("Name must contain letters, dash and spaces only")';
                        echo '</script>';
                    } else {
                        $counter++;
                    }
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("Name must contain at least two words")';
                    echo '</script>';
                }
            } else {
                echo '<script language="javascript">';
                echo 'alert("First letter of Name needs To Be Alphabatic")';
                echo '</script>';
            }

        } else {
            echo '<script language="javascript">';
            echo 'alert("Name can not be empty")';
            echo '</script>';
        }

        if ($_POST["email"] != "") {
            if (strpos($_POST["email"], '@') !== false && strpos($_POST["email"], '.') !== false && strlen($_POST["email"]) > 2 && ctype_alpha($_POST["email"][0]) && ctype_alpha($_POST["email"][strlen($_POST["email"]) - 1]) && ctype_alpha($_POST["email"][strpos($_POST["email"], '@') + 1]) && ctype_alpha($_POST["email"][strpos($_POST["email"], '.') + 1])) {
                $counter++;
            } else {
                echo '<script language="javascript">';
                echo 'alert("Invalid Email")';
                echo '</script>';
            }
        } else {
            echo '<script language="javascript">';
            echo 'alert("Email can not be empty")';
            echo '</script>';
        }
        if ($_POST["comment"] != "") {
            $counter++;
        } else {
            echo '<script language="javascript">';
            echo 'alert("Comment can not be empty")';
            echo '</script>';
        }

        if ($counter === 2) {
            $sqlInsertComment = "INSERT INTO comments (post_id, parent_id, comment_date, name, email, comment, is_active, is_approved) VALUES ('" . $_GET['id'] . "', NULL,'" . date("Y-m-d") . "','" . $_POST['name'] . "','" . $_POST['email'] . "','" . $_POST['comment'] . "','1','0');";
            if ($con->query($sqlComment)) {
                echo '<script language="javascript">';
                echo 'alert("Comment Added, Waiting For Approval")';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'alert("Something Went Wrong")';
                echo '</script>';
            }

        } else {
            echo '<script language="javascript">';
            echo 'alert("Something Went Wrongggggggg")';
            echo '</script>';
        }
    }

}
?>