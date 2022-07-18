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
                    <a href="../logout.php"> Logout </a>
                </div>
            </div>
        </nav>
        <div class="page_header">
            <h2> Admin Portal </h2>
        </div>

        <?php
        // Fetching data                            
        $class_query = "SELECT * FROM tblclasses";
        $class_result = mysqli_query($connection, $class_query);

        ?>
        <!-- New Record Form -->
        <div class="formContainer-flexbox">
            <form action="create_successful.php" method="post">
                <input type="text" name="className" required placeholder="Class Name">
                <input type="text" name="section" required placeholder="Section">
                <button type="submit"> Save </button>
                <button type="cancel" onclick="window.location='index.php';return false;">Cancel</button>
            </form>
        </div>
        <section>
            <!-- Table Construction-->
            <table>
                <tr>
                    <th> S.No </th>
                    <th> Class </th>
                    <th> Section </th>
                </tr>
                <!-- Php code to fetch data from rows -->
                <?php  // Loop till end of data
                $sno = 1;
                while ($rows = $class_result->fetch_assoc()) {
                ?>
                    <tr>
                        <!-- Fetching data from each row of every column -->
                        <td> <?php echo $sno; ?> </td>
                        <td> <?php echo $rows["ClassName"]; ?> </td>
                        <td> <?php echo $rows["Section"]; ?> </td>
                    </tr>
                <?php
                    $sno += 1;
                }
                ?>
            </table>
        </section>
        <footer>
            <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
        </footer>
    </body>

    </html>
<?php
}
?>