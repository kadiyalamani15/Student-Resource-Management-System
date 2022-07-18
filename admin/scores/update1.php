<?php
include_once '../../srms.php';

$update_query = "UPDATE tblresult SET s_marks='" . $_POST['score'] . "'" . "WHERE rID='" . $_POST['resID'] . "'";
mysqli_query($connection, $update_query);

header('Location:index.php');
