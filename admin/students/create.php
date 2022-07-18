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
        // Fetching data                            
        $std_query = "SELECT * FROM tblstudents";
        $std_result = mysqli_query($connection, $std_query);
        $class_query = "SELECT DISTINCT ClassName FROM tblclasses";
        $class = mysqli_query($connection, $class_query);
        ?>
        <!-- New Record Form -->
        <div class="formContainer-flexbox">
            <form action="create_successful.php" method="post">
                <input type="text" name="stdName" required placeholder="Student Name">
                <input type="text" name="stdRoll" required placeholder="Roll No">
                <!-- Class Dropdown -->
                <select name="stdClass" id="class_list" onChange="getSection(this.value);">
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
                <select name="stdSection" id="section_list">
                    <option value disabled selected>Sec</option>
                </select>
                <button type="submit"> Save </button>
                <button type="cancel" onclick="window.location='index.php';return false;">Cancel</button>
            </form>
        </div>
        <section>
            <!-- Table Construction -->
            <table>
                <tr>
                    <th> S.No </th>
                    <th> Student </th>
                    <th> Roll No </th>
                    <th> Class </th>
                    <th> Section </th>
                </tr>
                <!-- Php code to Fetch Data from Rows -->
                <?php  // Loop till end of data 
                $sno = 1;
                while ($rows = $std_result->fetch_assoc()) {
                ?>
                    <tr>
                        <!-- Fetching data from each row of every column -->
                        <td> <?php echo $sno; ?> </td>
                        <td> <?php echo $rows["StudentName"]; ?> </td>
                        <td> <?php echo $rows["RollID"]; ?> </td>
                        <?php $class = "SELECT * FROM tblclasses WHERE ClassID ='" . $rows["fK_classID"] . "'";
                        $query = mysqli_query($connection, $class);
                        if (mysqli_num_rows($query) > 0) {
                            $class_row = mysqli_fetch_assoc($query);
                        ?>
                            <td> <?php echo $class_row["ClassName"] ?> </td>
                            <td> <?php echo $class_row['Section'] ?> </td>
                        <?php
                        } else {
                        ?>
                            <td> <?php echo "NA"; ?> </td>
                            <td> <?php echo "NA"; ?></td>
                        <?php
                        }
                        ?>
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