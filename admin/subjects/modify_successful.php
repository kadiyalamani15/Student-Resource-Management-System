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
            $id = $_POST['subID'];
            $sub = $_POST['subName'];
            $code = $_POST['code'];

            // Check for duplicacy
            $exists = "SELECT * FROM tblsubjects WHERE SubjectName='" . $sub . "'" . "AND SubjectCode='" . $code . "'";
            $entries = mysqli_query($connection, $exists);
            $duplicacy = mysqli_num_rows($entries);
            if ($duplicacy > 0) {
                echo "Sub: " . $sub . " and Section: " . $code . " already exists";
            } else {
                // Modifying Existing
                $code_exists = "SELECT * FROM tblsubjects WHERE SubjectCode='" . $code . "'";
                $code_entries = mysqli_query($connection, $code_exists);
                $code_duplicacy = mysqli_num_rows($code_entries);
                if ($code_duplicacy > 0) {
                    echo "Subject Code: " . $code . " already exists";
                } else {
                    $update_query = "UPDATE tblsubjects SET SubjectName='$sub', SubjectCode='$code'
                                    WHERE SubjectID='$id'";

                    if (mysqli_query($connection, $update_query)) {
                        echo "Record is updated";
                    } else {
                        echo "Error: " . $update_query . " " . mysqli_error($connection);
                    }
                }
            }
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