<!doctype html>

<html>

<!--
    
    Project 02.08.01
    
    Author: Abraham Aguilar
    Date: 11.07.18
    
    InterviewLog.php
    
-->

<head>
    <title>Interview Log</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
    <link href="Interview.css" rel="stylesheet">
</head>

<body>
    <h1>View Logged Interviews</h1>
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
        } else {
            $sql = "CREATE DATABASE $DBName";
            if (mysqli_query($DBConnect, $sql)) {
                $success = mysqli_select_db($DBConnect, $DBName);
                if ($success) {
                }
            } else {
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
            } else {
                $success = true;
            }
        } else {
            $success = true;
        }
        return $success;
    }
    
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBName = "interviewlog";
    $tableName = "interviews";
    
    $DBConnect = connectToDB($hostName, $userName, $password);
    if ($DBConnect) { // checks for connection
        if (selectDB($DBConnect, $DBName)) { // selects a database
            if (createTable($DBConnect, $tableName)) { // creates and/or selects a table if needed
                echo "<h2>Visitors Log</h2>";
                $sql = "SELECT * FROM $tableName";
                $result = mysqli_query($DBConnect, $sql);
                if (mysqli_num_rows($result) === 0) {
                    echo "<p>There are no logged entries to review.</p>";
                } else {
                    echo "<table width='100%' border='1'>";
                    echo "<tr>";
                    echo "<th>Interview Number</th>";
                    echo "<th>Interviewer Name</th>";
                    echo "<th>Interviewer Position</th>";
                    echo "<th>Canidate Name</th>";
                    echo "<th>Communication Ability</th>";
                    echo "<th>Professional Appearance</th>";
                    echo "<th>Computer Skills</th>";
                    echo "<th>Business Knowledge</th>";
                    echo "<th>Interviewer's Comments</th>";
                    echo "<th>Interview Date</th>";
                    echo "</tr>\n";
                    while ($row = mysqli_fetch_row($result)) { // displays the data as long as there is data
                        echo "<tr style='text-align: center'>";
                        echo "<td>{$row[0]}</td>";
                        echo "<td>{$row[1]}</td>";
                        echo "<td>{$row[2]}</td>";
                        echo "<td>{$row[3]}</td>";
                        echo "<td>{$row[4]}</td>";
                        echo "<td>{$row[5]}</td>";
                        echo "<td>{$row[6]}</td>";
                        echo "<td>{$row[7]}</td>";
                        echo "<td>{$row[8]}</td>";
                        echo "<td>{$row[9]}</td>";
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
    <p><a href="InterviewResults.php">Back to Interview Submitting</a></p>
</body>

</html>
