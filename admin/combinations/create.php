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
                    <a href="../class/index.php">Class</a>
                    <a href="../students/index.php">Students</a>
                    <a href="../subjects/index.php">Subjects</a>
                    <a class="active" href="index.php">Combinations</a>
                    <a href="../scores/index.php">Scores</a>
                    <a href="../logout.php"> Logout </a>
                </div>
            </div>
        </nav>
        <div class="page_header">
            <h2> Admin Portal </h2>
        </div>

        <?php
        // Fetching data          
        $class = $_POST['class'];
        $sub_query = "SELECT * FROM tblsubjects";
        $sub_res = mysqli_query($connection, $sub_query);
        ?>
        <!-- New Record Form -->
        <div class="formContainer-flexbox">
            <form action="create_successful.php" method="post">
                <input name="class" value="<?php echo $class; ?>" hidden>
                <!-- Subject Dropdown -->
                <select name="subject" id="sub_list">
                    <option value disabled selected> Subject </option>
                    <?php
                    while ($row = $sub_res->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $row['SubjectID']; ?>"> <?php echo $row['SubjectName']; ?> </option>
                    <?php
                    }
                    ?>
                </select>
                <!-- Subject Code Dropdown Disabled value -->
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