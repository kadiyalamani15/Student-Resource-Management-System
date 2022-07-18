<?php
include_once '../../srms.php';

$score_query = "SELECT * FROM tblresult WHERE fk_studentID='" . $_POST['stdID'] . "'";
$score_res = mysqli_query($connection, $score_query);

if (mysqli_num_rows($score_res) > 0) {
?>

    <table>
        <tr>
            <th> S.No </th>
            <th> Subject </th>
            <th> Score </th>
        </tr>
        <?php
        $sno = 1;
        foreach ($score_res as $score_row) {
        ?>
            <tr>
                <td>
                    <?php echo $sno; ?>
                </td>
                <td>
                    <?php
                    $sub_query = "SELECT * FROM tblsubjects WHERE SubjectID='" . $score_row['fk_subjectID'] . "'";
                    $sub_res = mysqli_query($connection, $sub_query);
                    $row = mysqli_fetch_assoc($sub_res);
                    echo $row['SubjectName'] . " " . "[" . $row['SubjectCode'] . "]";
                    ?>
                </td>
                <td>
                    <?php
                    if (is_null($score_row['s_marks'])) {
                    ?>
                        <form action="update.php" method="post">
                            <input name="resID" value="<?php echo $score_row['rID']; ?>" hidden>
                            <input name="score" type="text" placeholder="Enter Score">
                            <button type="submit"> Submit </button>
                        </form>
                    <?php
                    } else {
                    ?>
                        <form action="update.php" method="post">
                            <input name="resID" value="<?php echo $score_row['rID']; ?>" hidden>
                            <input name="score" value="<?php echo $score_row['s_marks']; ?>">
                            <button type="submit"> Submit </button>
                        </form>
                    <?php
                    }
                    ?>

                </td>
            </tr>
        <?php
            $sno += 1;
        }
        ?>
    </table>
<?php
} else {
    echo "";
}
?>