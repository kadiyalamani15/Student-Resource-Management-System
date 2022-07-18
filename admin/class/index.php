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
        <title> Admin Portal - Subjects </title>
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

        <!-- Page Titile -->
        <div class="page_header">
            <h1> UNIVERSITY OF XYZ </h1>
        </div>
        <div class="pageTitle">
            <h2> Class Dashboard </h2>
        </div>
        <?php
        // Fetch classes data
        $class_query = "SELECT * FROM tblclasses";
        $class_result = mysqli_query($connection, $class_query);

        mysqli_close($connection);

        ?>
        <div class="formContainer-flexbox">
            <form action="create.php">
                <button type="submit"> Add </button>
            </form>
        </div>

        <section>
            <!-- Table Construction -->
            <table>
                <tr>
                    <th> S.No </th>
                    <th> Class </th>
                    <th> Section </th>
                </tr>
                <!-- Php code to Fetch Data from Rows -->
                <?php  // Loop till end of data 
                $sno = 1;
                while ($rows = $class_result->fetch_assoc()) {
                ?>
                    <tr>
                        <!-- Fetching data from each row of every column -->
                        <td> <?php echo $sno; ?> </td>
                        <td> <?php echo $rows["ClassName"]; ?> </td>
                        <td> <?php echo $rows["Section"]; ?> </td>
                        <td>
                            <form action="modify.php" method="post">
                                <input name="classID" value=<?php echo $rows["ClassID"]; ?> hidden>
                                <button type="submit"> Edit </button>
                            </form>
                        </td>

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