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
        // Create New Record
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $classname = $_POST['class'];
            $subID = $_POST['subject'];
            $classID_query = "SELECT ClassID FROM tblclasses WHERE ClassName='$classname'";
            $classID_res = mysqli_query($connection, $classID_query);
            $classID = mysqli_fetch_assoc($classID_res);
            // Check for duplicacy
            $exists = "SELECT * FROM tblsubjectcombination WHERE fk_classID='" . $classID['ClassID'] . "'" . "AND fk_subjectID='" . $subID . "'";
            $entries = mysqli_query($connection, $exists);
            $duplicacy = mysqli_num_rows($entries);
            if ($duplicacy > 0) {
                echo "Record already exists";
            } else {
                // Insert Query
                foreach ($classID_res as $ID) {
                    $sql = "INSERT INTO tblsubjectcombination(fk_classID, fk_subjectID) VALUES (" . $ID['ClassID'] . ", $subID) ";
                    if (mysqli_query($connection, $sql)) {
                        $std_query = "SELECT StudentID FROM tblstudents WHERE fK_classID='" . $ID['ClassID'] . "'";
                        if ($std_res = mysqli_query($connection, $std_query)) {
                            foreach ($std_res as $stdID) {
                                // check for exists
                                $rec_exists_query = "SELECT * FROM tblresult WHERE fk_studentID='" . $stdID['StudentID'] . "' AND fk_classID='" . $ID['ClassID'] . "' AND fk_subjectID='" . $subID . "'";
                                $rec_exists_res = mysqli_query($connection, $rec_exists_query);
                                if (mysqli_num_rows($rec_exists_res) > 0) {
                                    echo "Record " . $stdID['ClassID'] . " " . $ID['ClassID'] . " " . $subID . "already present in Result table <br>";
                                } else {
                                    $res_query = "INSERT INTO tblresult(fk_studentID, fk_classID, fk_subjectID,s_marks) VALUES (" . $stdID['StudentID'] . "," . $ID['ClassID'] . "," . $subID . ", NULL)";
                                    if (mysqli_query($connection, $res_query)) {
                                        echo "Record " . $stdID['ClassID'] . " " . $ID['ClassID'] . " " . $subID . " updated in Result table <br>";
                                    } else {
                                        echo "Record " . $stdID['ClassID'] . " " . $ID['ClassID'] . " " . $subID . " could not be updated in Result Table <br>";
                                    }
                                }
                            }
                        }
                    } else {
                        echo "Error: " . $sql . " " . mysqli_error($connection);
                    }
                }
                echo "Record updated successfully <br>";
            }
            mysqli_close($connection);
        }
        ?>

        <!-- Redirecting to Create -->
        <script>
            var timer = setTimeout(function() {
                window.location = "index.php"
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