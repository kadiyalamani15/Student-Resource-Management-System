<?php
// database config file
include_once '../../srms.php';

// Generate Sections for LIKE class
$classID = $_POST['classID'];
?>
<?php
$stdID_query = "SELECT DISTINCT fk_studentID FROM tblresult WHERE fk_classID='$classID'";
$stdID_res = mysqli_query($connection, $stdID_query);
if (mysqli_num_rows($stdID_res) > 0) {
?>
    <html>
    <option value disabled selected> Student </option>
    <?php
    foreach ($stdID_res as $ID) {
        $stdName_query = "SELECT StudentName FROM tblstudents WHERE StudentID='" . $ID['fk_studentID'] . "'";
        $result = mysqli_query($connection, $stdName_query);
        while ($rows = $result->fetch_assoc()) {
    ?>
            <option value="<?php echo $ID['fk_studentID']; ?>"> <?php echo $rows["StudentName"]; ?> </option>
    <?php
        }
    }
    ?>

    </html>
<?php
} else {
?>
    <html>
    <option value disabled selected> Student </option>
    <option value="<?php echo "NULL" ?>"> <?php echo "NA"; ?> </option>

    </html>
<?php
}
?>