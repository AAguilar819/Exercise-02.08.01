<!doctype html>

<html>

<!--
    
    Exercise 02.08.01
    
    Author: Abraham Aguilar
    Date: 11.01.18
    
    SelectTest.php
    
-->

<head>
    <title>Select Test</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h2>Select Test</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBName = "newsletter2";
    $DBConnect = mysqli_connect($hostName, $userName, $password);
    
    if (!$DBConnect) { // inform if the database was able to be connected to
        echo "<p>Connection failed.</p>\n";
    } else {
        if (mysqli_select_db($DBConnect, $DBName)) { // attempts to connect to the database. if it can, inform the user, otherwise give a reason.
            echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
        } else {
            echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . ".</p>\n";
        }
        
        mysqli_close($DBConnect);
    }
    ?>
</body>

</html>
