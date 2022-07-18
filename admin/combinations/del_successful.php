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
                    <a href="../subjects/index.php">Subjects</a>
                    <a class="active" href="index.php">Combinations</a>
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
            $classname = $_POST['classname'];
            $subID = $_POST['subID'];
            $classID_query = "SELECT ClassID FROM tblclasses WHERE ClassName='$classname'";
            $classID_res = mysqli_query($connection, $classID_query);
            foreach ($classID_res as $ID) {
                $del_query = "DELETE FROM tblsubjectcombination WHERE fk_classID='" . $ID['ClassID'] . "' AND fk_subjectID='$subID'";
                mysqli_query($connection, $del_query);
                $res_del_query = "DELETE FROM tblresult WHERE fk_classID='" . $ID['ClassID'] . "' AND fk_subjectID='$subID'";
                mysqli_query($connection, $res_del_query);
            }
            echo "Deleted Successfully";
        }
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