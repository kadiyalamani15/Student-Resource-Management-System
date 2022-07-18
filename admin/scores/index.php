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
        <title> Admin Portal - Scores </title>
        <!-- jQuery library -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function getSection(val) {
                $.ajax({
                    type: "POST",
                    url: "get_Section.php",
                    data: 'ClassName=' + val,
                    success: function(data) {
                        $("#section_list").html(data);
                    }
                });
            }

            function getStd(val) {
                $.ajax({
                    type: "POST",
                    url: "get_Std.php",
                    data: 'classID=' + val,
                    success: function(data) {
                        $("#student_list").html(data);
                    }
                });
            }

            function getScores(val) {
                $.ajax({
                    type: "POST",
                    url: "get_Scores.php",
                    data: 'stdID=' + val,
                    success: function(data) {
                        $("#scores_list").html(data);
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
                    <a href="../combinations/index.php">Combinations</a>
                    <a class="active" href="index.php">Scores</a>
                    <a href="../logout.php"> Logout </a>
                </div>
            </div>
        </nav>

        <!-- Page Titile -->
        <div class="page_header">
            <h1> UNIVERSITY OF XYZ </h1>
        </div>
        <div class="pageTitle">
            <h2> Scores Dashboard </h2>
        </div>
        <?php
        // Fetch classes data
        $class_query = "SELECT DISTINCT ClassName FROM tblclasses";
        $class = mysqli_query($connection, $class_query);

        mysqli_close($connection);

        ?>
        <div class="formContainer-flexbox">
            <!-- Result Form -->
            <form action='' method="POST">
                <!-- Class Dropdown -->
                <select name="Class" id="class_list" class="class" onChange="getSection(this.value);">
                    <option value disabled selected>Class</option>
                    <?php
                    while ($rows = $class->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $rows['ClassName']; ?>"><?php echo $rows['ClassName']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <!-- Section Dropdown -->
                <select name="Section" id="section_list" onChange="getStd(this.value);">
                    <option value disabled selected>Sec</option>
                </select>
                <select name="stdName" id="student_list" onChange="getScores(this.value);">
                    <option value disabled selected> Student </option>
                </select>
            </form>
        </div>
        <section>
            <table id="scores_list">

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