<!doctype html>

<html>

<!--
    
    Exercise 02.08.01
    
    Author: Abraham Aguilar
    Date: 11.01.18
    
    CreateNewsletterDB.php
    
-->

<head>
    <title>Create Newsletter DB</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h2>Create Newsletter DB</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBName = "newsletter2";
    $DBConnect = mysqli_connect($hostName, $userName, $password);
    
    if (!$DBConnect) { // inform if the database was able to be connected to
        echo "<p>Connection failed.</p>\n";
    } else {
        $sql = "CREATE DATABASE $DBName";
        
        if (mysqli_query($DBConnect, $sql)) { // attempts to create the database.  if it exists, inform the user, otherwise give a reason.
            echo "<p>Successfully created the \"$DBName\" database.</p>\n";
        } else {
            echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . ".</p>\n";
        }
        
        mysqli_close($DBConnect);
    }
    ?>
</body>

</html>
