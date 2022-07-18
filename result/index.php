<?php
// Database config file
include_once '../srms.php';

// Fetch all Class and Section data
$class_query = "SELECT DISTINCT ClassName FROM tblclasses";
//$section_query = "SELECT Section FROM tblclasses";
$class = mysqli_query($connection, $class_query);
//$section = mysqli_query($connection,$section_query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> SRMS </title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- jQuery library -->
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
    <div class="formContainer-flexbox">
        <!-- Result Form -->
        <form action='result.php' method="POST">
            <!-- Roll no Input -->
            <input id="rollno" type="text" name="RollNo" placeholder="Roll No" required>
            <!-- Class Dropdown -->
            <select name="Class" id="class_list" onChange="getSection(this.value);">
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
            <select name="Section" id="section_list">
                <option value disabled selected>Sec</option>
            </select>
            <button name='result' value="0">View Result</button>
            <button name='result' value="1">Download PDF</button>
            <!--<input id="checkResults" type="submit" value="Result">-->
        </form>
    </div>
    <footer>
        <p> <a href="mailto:kadiyala.mani15@gmail.com"> © Manish Chandra Kadiyala 2022 </a> </p>
    </footer>
</body>

</html>