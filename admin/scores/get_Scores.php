<?php
include_once '../../srms.php';

$score_query = "SELECT * FROM tblresult WHERE fk_studentID='" . $_POST['stdID'] . "'";
$score_res = mysqli_query($connection, $score_query);

if (mysqli_num_rows($score_res) > 0) {
?>
    <form action="update.php" method="POST" id="scores"></form>
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
                <?php
                if (is_null($score_row['s_marks'])) {
                ?>
                    <td>
                        <input type="text" name="<?php echo $score_row['rID']; ?>" form="scores" placeholder="Enter Score" />
                    </td>
                <?php
                } else {
                ?>
                    <td>
                        <input type="text" name="<?php echo $score_row['rID'] ?>" value="<?php echo $score_row['s_marks']; ?>" form="scores" />
                    </td>
                <?php
                }
                ?>
            </tr>
        <?php
            $sno += 1;
        }
        ?>
        <tr>
            <td></td>
            <td></td>
            <td>
                <input name="stdID" value="<?php echo $_POST['stdID']; ?>" form="scores" hidden>
                <button type="submit" form="scores"> Submit </button>
            </td>
        </tr>
    </table>
<?php
} else {
    echo "";
}
?>