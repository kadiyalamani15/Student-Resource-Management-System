<?php
// database config file
include_once '../srms.php';

// Generate Sections for LIKE class
$query = "SELECT * FROM tblclasses WHERE ClassName LIKE '" . $_POST["Class_ID"] . "'";
$result = mysqli_query($connection, $query);
?>

<html>
<option value disabled selected> Sec </option>
<?php
while ($rows = $result->fetch_assoc()) {

?>
    <option value="<?php echo $rows["Section"]; ?>"> <?php echo $rows["Section"]; ?> </option>

<?php
}
?>

</html>