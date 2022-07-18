<?php 
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'SRMS';

    $connection = mysqli_connect($servername,$username,$password,$dbname);

    if (!$connection) {
        die ('Could not connect MySQL: '.mysqli_connect_error());
    }
?>