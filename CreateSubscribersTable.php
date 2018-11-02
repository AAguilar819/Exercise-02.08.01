<!doctype html>

<html>

<!--
    
    Exercise 02.08.01
    
    Author: Abraham Aguilar
    Date: 11.01.18
    
    CreateSubscribersTable.php
    
-->

<head>
    <title>Create Subscribers Table</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h2>Create Subscribers Table</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBName = "newsletter2";
    $tableName = "subscribers";
    $DBConnect = mysqli_connect($hostName, $userName, $password);
    
    if (!$DBConnect) { // inform if the database was able to be connected to
        echo "<p>Connection failed.</p>\n";
    } else {
        if (mysqli_select_db($DBConnect, $DBName)) { // attempts to connect to the database.  if it can, inform the user, otherwise give a reason.
            echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
            $sql = "SHOW TABLES LIKE '$tableName'";
            $results = mysqli_query($DBConnect, $sql);
            
            if (mysqli_num_rows($results) == 0) { // checks if there's an existing table.  if not, make the table
                echo "The <strong>$tableName</strong> table does not exist, creating it.<br>\n";
                $sql = "CREATE TABLE $tableName (subscriberID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, " . 
                " name VARCHAR(80), email VARCHAR(100), subscribeDate DATE, confirmDate DATE)";
                $results = mysqli_query($DBConnect, $sql);
                
                if (!$results) {
                    echo "<p>Unable to create the <strong>$tableName</strong> table.</p>";
                    echo "<p>Error Code: " . mysqli_error($DBConnect) . ".</p>";
                } else {
                    echo "<p>Successfully created the <strong>$tableName</strong> table.</p>";
                }
            } else {
                echo "The <strong>$tableName</strong> table already exist.<br>\n";
            }
            
        } else {
            echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . ".</p>\n";
        }
        
        mysqli_close($DBConnect);
    }
    ?>
</body>

</html>
