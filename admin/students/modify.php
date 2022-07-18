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
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function getSection(val) {
                $.ajax({
                    type: "POST",
                    url: "get_Section.php",
                    data: 'Class_ID=' + val,
                    success: function(data) {
                        $("#section_list").html(data);
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
                    <a class="active" href="index.php">Students</a>
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
        $std_id = $_POST['stdID'];
        $class_id = $_POST['classID'];

        // Fetching data 
        $std_query = "SELECT * FROM tblstudents WHERE StudentID = '$std_id'";
        $std_result = mysqli_query($connection, $std_query);
        $row = mysqli_fetch_array($std_result);
        $class_query = "SELECT DISTINCT ClassName FROM tblclasses";
        $class = mysqli_query($connection, $class_query);
        $class_sel = "SELECT * FROM tblclasses WHERE ClassID ='" . $class_id . "'";
        $query = mysqli_query($connection, $class_sel);
        if (mysqli_num_rows($query) > 0) {
            $class_row = mysqli_fetch_assoc($query);
        ?>

            <!-- Modify Form with pre-filled values -->
            <div class="formContainer-flexbox">
                <form action="modify_successful.php" method="post">
                    <input type="text" name="stdID" value=<?php echo $std_id; ?> hidden>
                    <input type="text" name="stdName" value=<?php echo $row[1]; ?> required>
                    <input type="text" name="stdRoll" value=<?php echo $row[2]; ?> required>
                    <select name="stdClass" id="class_list" onChange="getSection(this.value);">
                        <option value="<?php echo $class_row['ClassName']; ?>" disabled selected><?php echo $class_row['ClassName']; ?></option>
                        <?php
                        while ($rows = $class->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $rows['ClassName']; ?>"> <?php echo $rows['ClassName']; ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <select name="stdSection" id="section_list">
                        <option value disabled selected>Sec</option>
                    </select>

                    <button type="submit"> Save </button>
                    <button type="cancel" onclick="window.location='index.php';return false;">Cancel</button>
                </form>
            <?php
        }
            ?>
            </div>
            <footer>
                <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
            </footer>
    </body>

    </html>
<?php
}
?>