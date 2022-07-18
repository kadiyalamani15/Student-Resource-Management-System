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
                    <a class="active" href="index.php">Students</a>
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['stdID'];
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
                // Modifying Existing
                $class_verify = "SELECT * FROM tblclasses WHERE ClassName='$class' AND Section='$section'";
                $verify_res = mysqli_query($connection, $class_verify);
                if (mysqli_num_rows($verify_res) > 0) {
                    $fK_classID = "SELECT ClassID FROM tblclasses WHERE ClassName='$class' AND Section='$section'";
                    $fK_classID_result = mysqli_query($connection, $fK_classID);
                    $fk_row = mysqli_fetch_assoc($fK_classID_result);
                    $update_query = "UPDATE tblstudents SET StudentName='$name', RollID='$roll', fK_classID='" . $fk_row['ClassID'] . "'" . " WHERE StudentID='$id'";
                    if (mysqli_query($connection, $update_query)) {
                        echo "Record is updated <br>";
                        $res_dupliate_query = "SELECT * FROM tblresult WHERE fk_studentID='$id' AND fk_classID='" . $fk_row['ClassID'] . "'";
                        $res_duplicate = mysqli_query($connection, $res_dupliate_query);
                        if (mysqli_num_rows($res_duplicate) > 0) {
                            echo "Class is not updated <br>";
                        } else {
                            $res_del_query = "DELETE FROM tblresult WHERE fk_studentID='$id'";
                            mysqli_query($connection, $res_del_query);
                            $sub_query = "SELECT DISTINCT fk_subjectID FROM tblsubjectcombination WHERE fk_classID ='" . $fk_row['ClassID'] . "'";
                            $sub_res = mysqli_query($connection, $sub_query);
                            if (mysqli_num_rows($sub_res) > 0) {
                                foreach ($sub_res as $subID) {
                                    //echo $subID['fk_subjectID'] . "<br>";
                                    $res_tbl_query = "INSERT INTO tblresult(fk_studentID, fk_classID, fk_subjectID, s_marks) VALUES (" . $id . "," . $fk_row['ClassID'] . "," . $subID['fk_subjectID'] . ", NULL)";
                                    mysqli_query($connection, $res_tbl_query);
                                }
                            } else {
                                echo "Error in updating Results table";
                            }
                        }
                    } else {
                        echo "Error: " . $update_query . " " . mysqli_error($connection);
                    }
                } else {
                    echo "Cannot update requested record with entered details, Please enter correct details";
                }
            }
        }
        mysqli_close($connection);
        ?>

        <!-- Redirect to Modify -->
        <script>
            var timer = setTimeout(function() {
                window.location = "index.php"
            }, 3000);
        </script>
        <footer>
            <footer>
                <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
            </footer>
    </body>

    </html>

<?php
}
?>