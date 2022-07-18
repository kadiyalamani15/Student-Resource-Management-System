<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:admin_login.php');
} else {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
        <title> Admin Portal - Dashboard </title>
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
                    <a class="active" href="index.php">Home</a>
                    <a href="./class/index.php">Class</a>
                    <a href="./students/index.php">Students</a>
                    <a href="./subjects/index.php">Subjects</a>
                    <a href="./combinations/index.php">Combinations</a>
                    <a href="./scores/index.php">Scores</a>
                    <a href="logout.php"> Logout </a>
                </div>
            </div>
        </nav>

        <!-- Page Titile -->
        <div class="page_header">
            <h1> UNIVERSITY OF XYZ </h1>
        </div>
        <div class="pageTitle">
            <h2> Admin Portal </h2>
        </div>
        <footer>
            <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
        </footer>
    </body>

    </html>
<?php
}
?>