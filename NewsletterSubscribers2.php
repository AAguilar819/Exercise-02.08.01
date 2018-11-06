<!doctype html>

<html>

<!--
    
    Exercise 02.08.01
    
    Author: Abraham Aguilar
    Date: 11.05.18
    
    NewsletterSubscribers2.php
    
-->

<head>
    <title>Newsletter Subscribers 2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h2>Newsletter Subscribers 2</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBName = "newsletter2";
    $tableName = "subscribers";
    $DBConnect = mysqli_connect($hostName, $userName, $password);
    
    if (!$DBConnect) { // inform if the database was able to be connected to
        echo "<p>Connection error: " . mysqli_connect_error($DBConnect) . "</p>\n";
    } else {
        if (mysqli_select_db($DBConnect, $DBName)) { // attempts to connect to the database.  if it can, inform the user, otherwise give a reason.
            echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
            $sql = "SELECT * FROM $tableName";
            $results = mysqli_query($DBConnect, $sql);
            //displays all the table data from the database as table data on HMTL
            echo "<p>Number of rows in <strong>$tableName</strong>: " . mysqli_num_rows($results) . "</p>\n";
            echo "<table width='100%' border='1'>";
            echo "<tr>";
            echo "<th>Subscriber ID</th>";
            echo "<th>Name</th>";
            echo "<th>E-mail</th>";
            echo "<th>Subscribe Date</th>";
            echo "<th>Confirm Date</th>";
            echo "</tr>\n";
            while ($row = mysqli_fetch_assoc($results)) { // displays the data as long as there is data, this time using associative arrays.
                echo "<tr>";
                foreach ($row as $field) {
                    echo "<td>{$field}</td>";   
                }
                echo "</tr>\n";
            }
            echo "</table>\n";
            mysqli_free_result($results);
        } else {
            echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . ".</p>\n";
        }
        
        mysqli_close($DBConnect);
    }
    ?>
</body>

</html>
