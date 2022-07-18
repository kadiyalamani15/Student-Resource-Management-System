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
        // Create New Record
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['stdName'];
            $roll = $_POST['stdRoll'];
            $class = $_POST['stdClass'];
            $section = $_POST['stdSection'];

            // Check for duplicacy
            $exists = "SELECT * FROM tblstudents WHERE StudentName='" . $name . "'" . "AND RollID='" . $roll . "'" . "AND fK_classID = (" . "SELECT ClassID FROM tblclasses WHERE ClassName='" . $class . "'" . "AND Section='" . $section . "'" . ")";
            $entries = mysqli_query($connection, $exists);
            $duplicacy = mysqli_num_rows($entries);
            if ($duplicacy > 0) {
                echo  $name . " " . $roll . " " . $class . " " . $section . " already exists";
            } else {
                $fK_classID = "SELECT ClassID FROM tblclasses WHERE ClassName='$class' AND Section='$section'";
                $fK_classID_result = mysqli_query($connection, $fK_classID);
                $fk_row = mysqli_fetch_assoc($fK_classID_result);
                // Insert Query
                $sql = "INSERT INTO tblstudents(StudentID, StudentName, RollID, fK_classID) VALUES (NULL, '$name', '$roll'," . $fk_row['ClassID'] . ")";
                if (mysqli_query($connection, $sql)) {
                    echo "Student: " . $name . "  Roll No: " . $roll . " . Class: " . $class . " and Section: " . $section . " is added to the database successfully! <br>";
                    $stdID_query = "SELECT StudentID FROM tblstudents WHERE StudentName='$name' AND RollID='$roll' AND fK_classID='" . $fk_row['ClassID'] . "'";
                    $stdID_res = mysqli_query($connection, $stdID_query);
                    $stdID = mysqli_fetch_assoc($stdID_res);
                    //echo $stdID['StudentID'] . "<br>";
                    $sub_query = "SELECT DISTINCT fk_subjectID FROM tblsubjectcombination WHERE fk_classID ='" . $fk_row['ClassID'] . "'";
                    $sub_res = mysqli_query($connection, $sub_query);
                    if (mysqli_num_rows($sub_res) > 0) {
                        foreach ($sub_res as $subID) {
                            //echo $subID['fk_subjectID'] . "<br>";
                            $res_tbl_query = "INSERT INTO tblresult(fk_studentID, fk_classID, fk_subjectID, s_marks) VALUES (" . $stdID['StudentID'] . "," . $fk_row['ClassID'] . "," . $subID['fk_subjectID'] . ", NULL)";
                            mysqli_query($connection, $res_tbl_query);
                        }
                    } else {
                        echo "Error in updating Results table";
                    }
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