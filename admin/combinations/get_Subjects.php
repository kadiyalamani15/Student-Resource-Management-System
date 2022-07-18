<?php
// database config file
include_once '../../srms.php';

// Generate Sections for LIKE class
$classID_query = "SELECT ClassID FROM tblclasses WHERE ClassName LIKE '" . $_POST['ClassName'] . "'";
$classID_result = mysqli_query($connection, $classID_query);
$classID = mysqli_fetch_assoc($classID_result);

$class_in_comb = "SELECT fk_classID FROM tblsubjectcombination WHERE fk_classID='" . $classID['ClassID'] . "'";
$class_in_comb = mysqli_query($connection, $class_in_comb);

if (mysqli_num_rows($class_in_comb) > 0) {
    //echo "Class ID " . $classID['ClassID'] . "<br>";
    $subID_query = "SELECT fk_subjectID FROM tblsubjectcombination WHERE fk_classID = '" . $classID['ClassID'] . "'";
    $subID_res = mysqli_query($connection, $subID_query);

    //echo "Subject IDs " . "<br>";
?>
    <table>
        <tr>
            <th> S.No </th>
            <th> Subject </th>
            <th> Code </th>
        </tr>
        <?php
        $sno = 1;
        foreach ($subID_res as $subID) {

            $subname_query = "SELECT * FROM tblsubjects WHERE SubjectID ='" . $subID['fk_subjectID'] . "'";
            $subname_res = mysqli_query($connection, $subname_query);
            $subname = mysqli_fetch_assoc($subname_res);
        ?>
            <tr>
                <td>
                    <?php echo $sno; ?>
                </td>
                <td>
                    <?php echo $subname['SubjectName']; ?>
                </td>
                <td>
                    <?php echo $subname['SubjectCode']; ?>
                </td>
                <td>
                    <form action="del_successful.php" method="post">
                        <input name="classname" value="<?php echo $_POST['ClassName']; ?>" hidden>
                        <input name="subID" value=<?php echo $subID['fk_subjectID']; ?> hidden>
                        <button type="submit"> DELETE </button>
                    </form>
                </td>
            </tr>
        <?php
            $sno += 1;
        }
        ?>
    </table>
<?php
} else {
    echo "Add Subjects to " . $_POST['ClassName'] . " Class";
}
?>