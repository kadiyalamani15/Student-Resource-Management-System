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
                    <a class="active" href="index.php">Class</a>
                    <a href="../students/index.php">Students</a>
                    <a href="../subjects/index.php">Subjects</a>
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
        $id = $_POST['classID'];

        // Fetching data 
        $class_query = "SELECT * FROM tblclasses WHERE ClassID = '$id'";
        $class_result = mysqli_query($connection, $class_query);
        $row = mysqli_fetch_array($class_result);

        mysqli_close($connection);
        ?>

        <!-- Modify Form with pre-filled values -->
        <div class="formContainer-flexbox">
            <form action="modify_successful.php" method="post">
                <input type="text" name="classID" value=<?php echo $id; ?> hidden>
                <input type="text" name="className" value="<?php echo $row[1] ?>" required>
                <input type="text" name="section" value="<?php echo $row[2]; ?>" required>
                <button type="submit"> Save </button>
                <button type="cancel" onclick="window.location='index.php';return false;">Cancel</button>
            </form>
        </div>
        <footer>
            <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
        </footer>
    </body>

    </html>
<?php
}
?>