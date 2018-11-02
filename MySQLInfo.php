<!doctype html>

<html>

<!--
    
    Exercise 02.08.01
    
    Author: Abraham Aguilar
    Date: 10.30.18
    
    MySQLInfo.php
    
-->

<head>
    <title>MySQLInfo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h2>MySQL Database Server Info</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBConnect = mysqli_connect($hostName, $userName, $password);
    
    if (!$DBConnect) { // inform if the database was able to be connected to.
        echo "<p>Connection failed.</p>\n";
    } else {
        echo "<p>Connection successful.</p>\n";
        mysqli_close($DBConnect);
    }
    ?>
</body>

</html>
