<?php  //connect using mySQLi
    $connection = mysqli_connect('', '', '', 'library');
    if (!$connection) { // connection is sucessful?
        echo 'Connection error ' . mysqli_connect_error();
    }
    ?>