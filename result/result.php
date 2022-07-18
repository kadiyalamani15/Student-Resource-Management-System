<?php
include_once '../srms.php';
require_once 'fpdf/fpdf.php';

if ($_POST['result'] == 0) {
    //echo "VIEW RESULT";
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title> Scores </title>
        <link rel="stylesheet" href="../css/style.css">
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
                    <a href="../vision.php">Vision</a>
                    <a href="../faculty.php">Faculty</a>
                    <a href="../contact.php">Contact</a>
                    <a class="active" href="index.php">SRMS</a>
                    <a href="../admin/index.php">Admin</a>
                </div>
            </div>
        </nav>
        <div class="page_header">
            <h1> UNIVERSITY OF XYZ </h1>
        </div>
        <div class="pageTitle">
            <h2> Student Result Management System </h2>
        </div>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $RollNo = $_POST['RollNo'];
            $Class = $_POST['Class'];
            $Section = $_POST['Section'];
            //echo $RollNo." ".$Class." ".$Section."<br>";

            if ($connection) {
                //echo "Connection established! <br>";
                $std_name_query = "SELECT * FROM tblstudents 
                                        WHERE RollID ='" . $RollNo . "'" . "AND fK_classID =
                                        (" . "SELECT ClassID FROM tblclasses 
                                        WHERE ClassName='" . $Class . "'" . "AND Section='" . $Section . "'" . ")";
                $std_name_result = mysqli_query($connection, $std_name_query);

                // Printing Student Details
                if (mysqli_num_rows($std_name_result) > 0) {
                    $row = mysqli_fetch_array($std_name_result);
        ?>
                    <div class="result">
                        <table>
                            <tr>
                                <th> Name: </th>
                                <td> <?php echo $row[1]; ?> </td>
                                <th> Class: </th>
                                <td> <?php echo $Class . " " . $Section; ?> </td>
                            </tr>
                        </table>
                        <table style="width: 100%;">
                            <tr>
                                <th colspan="5"> SCORES </th>
                            </tr>
                            <?php
                            $std_marks_query = "SELECT tblsubjects.SubjectName, tblresult.s_marks
                                                    FROM tblresult
                                                    INNER JOIN tblsubjects
                                                    ON tblresult.fk_subjectID = tblsubjects.SubjectID
                                                    WHERE tblresult.fk_studentID = '" . $row[0] . "'";
                            $std_marks_result = mysqli_query($connection, $std_marks_query);

                            // Individual Marks and their total
                            $total = 0;
                            $qty = 0;
                            ?>
                            <tr style="border: 3px solid;">
                                <?php
                                foreach ($std_marks_result as $row) {
                                ?>
                                    <th style="border: 3px solid;"> <?php echo $row["SubjectName"];
                                                                } ?> </th>
                                    <th> Total </th>
                            </tr>
                            <tr style="border: 3px solid;">
                                <?php
                                foreach ($std_marks_result as $row) {
                                ?>
                                    <td style="border: 3px solid;">
                                    <?php
                                    echo $row["s_marks"];
                                    $total += $row["s_marks"];
                                    $qty += 1;
                                }
                                    ?>
                                    </td>
                                    <td> <?php echo $total; ?></td>
                            </tr>
                        </table>
                        <table style="width: 200px;">
                            <tr>
                                <th style="text-align: right; width: 50%;"> Percentage </th>
                                <td style="text-align: left; width: 50%;"> <?php echo $total / $qty . " %"; ?></td>
                            </tr>
                        </table>
                    </div>
                <?php
                } else {
                    echo "No Record Exists";
                ?>
                    <script>
                        var timer = setTimeout(function() {
                            window.location = "index.php"
                        }, 3000);
                    </script>
        <?php
                }
                mysqli_close($connection);
            } else {
                die("Connection failed, Reason: " . mysqli_connect_error());
            }
        }
        ?>
        <footer>
            <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
        </footer>
    </body>

    </html>
    <?php
} else {
    $RollNo = $_POST['RollNo'];
    $Class = $_POST['Class'];
    $Section = $_POST['Section'];
    //echo $RollNo." ".$Class." ".$Section."<br>";

    if ($connection) {
        //echo "Connection established! <br>";
        $std_name_query = "SELECT * FROM tblstudents 
                             WHERE RollID ='" . $RollNo . "'" . "AND fK_classID =
                             (" . "SELECT ClassID FROM tblclasses 
                            WHERE ClassName='" . $Class . "'" . "AND Section='" . $Section . "'" . ")";
        $std_name_result = mysqli_query($connection, $std_name_query);

        // Printing Student Details
        if (mysqli_num_rows($std_name_result) > 0) {
            $row = mysqli_fetch_array($std_name_result);
            //echo "DOWNLOAD RESULT";
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->Image('../imgs/school-logo.jpg', 10, 10, -300);
            $pdf->SetFont("Arial", "B", 16);
            $pdf->Cell(200, 20, "SCORE CARD", "0", "1", "C");
            $pdf->Ln();
            $pdf->Cell(200, 20, "Name: " . $row[1] . "   Class: " . $Class . " " . $Section, "0", "1", "C");
            $std_marks_query = "SELECT tblsubjects.SubjectName, tblresult.s_marks
                                                    FROM tblresult
                                                    INNER JOIN tblsubjects
                                                    ON tblresult.fk_subjectID = tblsubjects.SubjectID
                                                    WHERE tblresult.fk_studentID = '" . $row[0] . "'";
            $std_marks_result = mysqli_query($connection, $std_marks_query);

            // Individual Marks and their total
            $total = 0;
            $qty = 0;

            $pdf->SetLeftMargin(30);
            foreach ($std_marks_result as $row) {
                $pdf->Cell(30, 10, $row['SubjectName'], "1", "0", "C");
            }
            $pdf->Cell(30, 10, "TOTAL", "1", "1", "C");
            foreach ($std_marks_result as $row) {
                $pdf->Cell(30, 10, $row["s_marks"], "1", "0", "C");
                $total += $row["s_marks"];
                $qty += 1;
            }
            $pdf->Cell(30, 10, $total, "1", "1", "C");
            $pdf->Cell(150, 20, "PERCENTAGE: " . $total / $qty, "0", "1", "C");
            $pdf->Output('D', 'result.pdf');
        } else {
    ?>
            <!DOCTYPE html>
            <html>

            <head>
                <title> Scores </title>
                <link rel="stylesheet" href="../css/style.css">
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
                            <a href="../vision.php">Vision</a>
                            <a href="../faculty.php">Faculty</a>
                            <a href="../contact.php">Contact</a>
                            <a class="active" href="index.php">SRMS</a>
                            <a href="../admin/index.php">Admin</a>
                        </div>
                    </div>
                </nav>
                <div class="page_header">
                    <h1> UNIVERSITY OF XYZ </h1>
                </div>
                <div class="pageTitle">
                    <h2> Student Result Management System </h2>
                </div>
                <?php
                echo "No Record Exists";
                ?>
                <script>
                    var timer = setTimeout(function() {
                        window.location = "index.php"
                    }, 3000);
                </script>
        <?php
        }
        mysqli_close($connection);
    } else {
        die("Connection failed, Reason: " . mysqli_connect_error());
    }
        ?>
        <footer>
            <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
        </footer>
            </body>

            </html>

        <?php
    }
        ?>