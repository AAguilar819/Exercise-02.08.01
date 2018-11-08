<!doctype html>

<html>

<!--
    
    Project 02.08.01
    
    Author: Abraham Aguilar
    Date: 11.05.18
    
    SignGuestBook.php
    
-->

<head>
    <title>Sign Guest Book</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>Sign Guest Book</h1>
    <?php
    function connectToDB ($hostName, $userName, $password) { // function to allow for quick connect.
        $DBConnect = mysqli_connect($hostName, $userName, $password);
        if (!$DBConnect) {
            echo "<p>Connection error: " . mysqli_connect_error() . "</p>\n";
        }
        return $DBConnect;
    }
    
    function selectDB ($DBConnect, $DBName) { // function to allow for quick database select
        $success = mysqli_select_db($DBConnect, $DBName);
        if ($success) {
            // echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
        } else {
            // echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . ".  Creating database.</p>\n";
            $sql = "CREATE DATABASE $DBName";
            if (mysqli_query($DBConnect, $sql)) {
                // echo "<p>Successfully created the \"$DBName\" database.</p>\n";
                $success = mysqli_select_db($DBConnect, $DBName);
                if ($success) {
                    // echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
                }
            } else {
                // echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
            }
        }
        return $success;
    }
    
    function createTable ($DBConnect, $tableName) { // function to allow for quick table creation
        $success = false;
        $sql = "SHOW TABLES LIKE '$tableName'";
        $result = mysqli_query($DBConnect, $sql);
        if (mysqli_num_rows($result) === 0) {
            // echo "The <strong>$tableName</strong> table does note exist, creating table.<br>\n";
            $sql = "CREATE TABLE $tableName (countID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, lastName VARCHAR(40), firstName VARCHAR(40))";
            $result = mysqli_query($DBConnect, $sql);
            if (!$result) {
                $success = false;
                // echo "<p>Unable to create the $tableName table.</p>";
                // echo "<p>Error Code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . ".</p>";
            } else {
                $success = true;
                // echo "<p>Successfully created the $tableName table.</p>";
            }
        } else {
            $success = true;
            // echo "The $tableName table already exists.<br>\n";
        }
        return $success;
    }
    
    // required variables to ensure the code will work
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBName = "guestbook";
    $tableName = "visitors";
    $firstName = "";
    $lastName = "";
    $formErrorCount = 0;
    
    if (isset($_POST['submit'])) { // if the form was submitted, start verifying
        $firstName = stripslashes($_POST['firstName']);
        $firstName = trim($firstName);
        $lastName = stripslashes($_POST['lastName']);
        $lastName = trim($lastName);
        
        if (empty($firstName) || empty($lastName)) { // checks for if there are empty inputs
            echo "<p>You must enter your first and last <strong>name</strong>.</p>\n";
            ++$formErrorCount;
        }
        if ($formErrorCount === 0) { // runs the database code if no errors are found
            $DBConnect = connectToDB($hostName, $userName, $password);
            if ($DBConnect) { // checks for connection
                if (selectDB($DBConnect, $DBName)) { // selects a database
                    if (createTable($DBConnect, $tableName)) { // creates and/or selects a table if needed
                        // echo "<p>Connection successful</p>\n";
                        $sql =  "INSERT INTO $tableName VALUES (NULL, '$lastName', '$firstName')";
                        $result = mysqli_query($DBConnect, $sql);
                        if (!$result) {
                            // echo "<p>Unable to execute the query.</p>";
                            // echo "<p>Error Code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . ".</p>";
                        } else { // data was able to be inputted
                            echo "<h3>Thank you for signing our guest book!</h3>";
                            $firstName = "";
                            $lastName = "";
                        }
                    }
                    mysqli_close($DBConnect); // necessary any time to ensure the database doesn't run out of ceonnections
                }
            }
        }
    }
    ?>
    <form action="SignGuestBook.php" method="post">
        <p><strong>First Name:</strong><br>
            <input type="text" name="firstName" value="<?php echo $firstName; ?>"></p>
        <p><strong>Last Name:</strong><br>
            <input type="text" name="lastName" value="<?php echo $lastName; ?>"></p>
        <p><input type="submit" name="submit" value="Submit"></p>
    </form>
    <?php
    $DBConnect = connectToDB($hostName, $userName, $password);
    if ($DBConnect) { // checks for connection
        if (selectDB($DBConnect, $DBName)) { // selects a database
            if (createTable($DBConnect, $tableName)) { // creates and/or selects a table if needed
                // echo "<p>Connection successful</p>\n";
                echo "<h2>Visitors Log</h2>";
                $sql = "SELECT * FROM $tableName";
                $result = mysqli_query($DBConnect, $sql);
                if (mysqli_num_rows($result) === 0) {
                    echo "<p>There are no entries in the quest book.</p>";
                } else {
                    echo "<table width='60%' border='1'>";
                    echo "<tr>";
                    echo "<th>Visitor</th>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "</tr>\n";
                    while ($row = mysqli_fetch_row($result)) { // displays the data as long as there is data
                        echo "<tr width='10%' style='text-align: center'>";
                        echo "<td>{$row[0]}</td>";
                        echo "<td>{$row[1]}</td>";
                        echo "<td>{$row[2]}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    mysqli_free_result($result);
                }
            }
        }
        mysqli_close($DBConnect); // necessary any time to ensure the database doesn't run out of ceonnections
    }
    ?>
</body>

</html>
