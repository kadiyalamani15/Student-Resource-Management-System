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
        <title> Admin Portal - Combinations </title>
        <!-- jQuery library -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function getSubjects(val) {
                $.ajax({
                    type: "POST",
                    url: "get_Subjects.php",
                    data: 'ClassName=' + val,
                    success: function(data) {
                        $("#subjects_list").html(data);
                    }
                });
            }
        </script>
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

        <!-- Page Titile -->
        <div class="page_header">
            <h1> UNIVERSITY OF XYZ </h1>
        </div>
        <div class="pageTitle">
            <h2> Subject Combinations Dashboard </h2>
        </div>
        <?php
        // Fetch classes data
        $class_query = "SELECT DISTINCT ClassName FROM tblclasses";
        $class_res = mysqli_query($connection, $class_query);
        ?>
        <div class="formContainer-flexbox">
            <form action="create.php" method="post">
                <select name="class" id="class_list" onChange="getSubjects(this.value);">
                    <option value disabled selected> Select Class </option>
                    <?php
                    while ($row = $class_res->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $row['ClassName']; ?>"> <?php echo $row['ClassName']; ?> </option>
                    <?php
                    }
                    ?>
                </select>
                <button type="submit"> Add Subjects </button>
            </form>
        </div>
        <section>
            <table id="subjects_list">

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