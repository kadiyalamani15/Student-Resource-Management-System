<?php
// database config file
include_once '../../srms.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:admin_login.php');
} else {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/style.css">
        <style>
            body {
                text-align: center;
            }
        </style>
    </head>

    <body>
        <!-- Navigation bar -->
        <nav class="navbar">
            <!-- LOGO -->
            <div class="logo"> LOGO </div>
            <!-- NAVIGATION MENU -->
            <div class="nav-links">
                <!-- USING CHECKBOX HACK -->
                <input type="checkbox" id="checkbox_toggle" />
                <label for="checkbox_toggle" class="hamburger">&#9776;</label>
                <!-- NAVIGATION MENUS -->
                <div class="menu">
                    <a href="../index.php">Home</a>
                    <a href="../class/index.php">Class</a>
                    <a href="../students/index.php">Students</a>
                    <a class="active" href="index.php">Subjects</a>
                    <a href="../combinations/index.php">Combinations</a>
                    <a href="../scores/index.php">Scores</a>
                    <a href="../../index.php"> Logout </a>
                </div>
            </div>
        </nav>
        <div class="page_header">
            <h2> Admin Portal </h2>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sub_id = $_POST['subID'];
            $fk_check_query1 = "SET FOREIGN_KEY_CHECKS=0";
            mysqli_query($connection, $fk_check_query1);
            $del_query = "DELETE FROM tblsubjects WHERE SubjectID='$sub_id'";
            if (mysqli_query($connection, $del_query)) {
                $del_query2 = "DELETE FROM tblresult WHERE fk_subjectID='$sub_id'";
                if (mysqli_query($connection, $del_query2)) {
                    $del_query3 = "DELETE FROM tblsubjectcombination WHERE fk_subjectID='$sub_id'";
                    if (mysqli_query($connection, $del_query3)) {
                        echo "Deleted Record";
                    } else {
                        echo "Deleted Record from Subject Combination table";
                    }
                } else {
                    echo "Deleted Record from Result table";
                }
            } else {
                echo "Failed to delete";
            }
        }
        $fk_check_query2 = "SET FOREIGN_KEY_CHECKS=1";
        mysqli_query($connection, $fk_check_query2);
        mysqli_close($connection);
        ?>

        <!-- Redirect to Modify -->
        <script>
            var timer = setTimeout(function() {
                window.location = "index.php"
            }, 3000);
        </script>
        <footer>
            <footer>
                <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
            </footer>
    </body>

    </html>

<?php
}
?>