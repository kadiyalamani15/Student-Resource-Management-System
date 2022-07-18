<?php
// databse config file
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
                    <a href="../index.php">Class</a>
                    <a href="../students/index.php">Students</a>
                    <a class="active" href="index.php">Subjects</a>
                    <a href="../combinations/index.php">Combinations</a>
                    <a href="../scores/index.php">Scores</a>
                    <a href="../logout.php"> Logout </a>
                </div>
            </div>
        </nav>
        <div class="page_header">
            <h2> Admin Portal </h2>
        </div>
        <?php
        // Create New Record
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sub = $_POST['subName'];
            $code = $_POST['code'];

            // Check for duplicacy
            $exists = "SELECT * FROM tblsubjects WHERE SubjectName='" . $sub . "'" . "AND SubjectCode='" . $code . "'";
            $entries = mysqli_query($connection, $exists);
            $duplicacy = mysqli_num_rows($entries);
            if ($duplicacy > 0) {
                echo "Class: " . $sub . " and Section: " . $code . " already exists";
            } else {
                // Insert Query
                $sql = "INSERT INTO tblsubjects(SubjectID, SubjectName, SubjectCode) VALUES (NULL, '$sub', '$code')";
                if (mysqli_query($connection, $sql)) {
                    echo "Sub: " . $sub . " with Code: " . $code . " is added to the database successfully!";
                } else {
                    echo "Error: " . $sql . " " . mysqli_error($connection);
                }
            }
            mysqli_close($connection);
        }
        ?>

        <!-- Redirecting to Create -->
        <script>
            var timer = setTimeout(function() {
                window.location = "create.php"
            }, 3000);
        </script>
        <footer>
            <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
        </footer>
    </body>

    </html>
<?php
}
?>