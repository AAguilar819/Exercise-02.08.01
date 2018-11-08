<!doctype html>

<html>

<!--
    
    Project 02.08.01
    
    Author: Abraham Aguilar
    Date: 11.06.18
    
    InterviewResults.php
    
-->

<head>
    <title>Interview Results</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
    <link href="Interview.css" rel="stylesheet">
</head>

<body>
    <h1>Interview Results</h1>
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
            $sql = "CREATE TABLE $tableName (interID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, interName VARCHAR(80), interPos VARCHAR(80), " .
                "caniName VARCHAR(80), commAblty VARCHAR(200), profAppr VARCHAR(200), compSkill VARCHAR(200), busnssKnow VARCHAR(200), " .
                "interComment VARCHAR(200), recordDate DATE)";
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
    
    // required variables to ensure the code will work
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBName = "interviewlog";
    $tableName = "interviews";
    $interName = "";
    $interPos = "";
    $caniName = "";
    $commAblty = "";
    $profAppr = "";
    $compSkill = "";
    $busnssKnow = "";
    $interComment = "";
    $formErrorCount = 0;
    
    if (isset($_POST['submit'])) { // if the form was submitted, start verifying
        $interName = stripslashes($_POST['interName']);
        $interName = trim($interName);
        $interPos = stripslashes($_POST['interPos']);
        $interPos = trim($interPos);
        $caniName = stripslashes($_POST['caniName']);
        $caniName = trim($caniName);
        $commAblty = stripslashes($_POST['commAblty']);
        $commAblty = trim($commAblty);
        $profAppr = stripslashes($_POST['profAppr']);
        $profAppr = trim($profAppr);
        $compSkill = stripslashes($_POST['compSkill']);
        $compSkill = trim($compSkill);
        $busnssKnow = stripslashes($_POST['busnssKnow']);
        $busnssKnow = trim($busnssKnow);
        $interComment = stripslashes($_POST['interComment']);
        $interComment = trim($interComment);
        $recordDate = $_POST['recordDate'];
        
        if (empty($interName) || empty($caniName)) { // the series of ifs check for empty fields
            echo "<p>You must enter the canidate and interviewer's <strong>name</strong>.</p>\n";
            ++$formErrorCount;
        }
        if (empty($interPos)) {
            echo "<p>You must enter the interviewer's <strong>position</strong>.</p>\n";
            ++$formErrorCount;
        }
        if (empty($commAblty)) {
            echo "<p>You must enter the canidate's <strong>communication ability</strong>.</p>\n";
            ++$formErrorCount;
        }
        if (empty($profAppr)) {
            echo "<p>You must enter the canidate's <strong>professional appearance</strong>.</p>\n";
            ++$formErrorCount;
        }
        if (empty($compSkill)) {
            echo "<p>You must enter the canidate's <strong>computer skills</strong>.</p>\n";
            ++$formErrorCount;
        }
        if (empty($busnssKnow)) {
            echo "<p>You must enter the canidate's <strong>business knowledge</strong>.</p>\n";
            ++$formErrorCount;
        }
        if (empty($interComment)) {
            echo "<p>You must enter the interviewer's <strong>comments</strong>.</p>\n";
            ++$formErrorCount;
        }
        if (empty($recordDate)) {
            echo "<p>You must enter the <strong>date</strong> of the interview.</p>\n";
            ++$formErrorCount;
        }
        if ($formErrorCount === 0) { // runs the database code if no errors are found
            $DBConnect = connectToDB($hostName, $userName, $password);
            if ($DBConnect) { // checks for connection
                if (selectDB($DBConnect, $DBName)) { // selects a database
                    if (createTable($DBConnect, $tableName)) { // creates and/or selects a table if needed
                        $sql =  "INSERT INTO $tableName VALUES (NULL, '$interName', '$interPos', '$caniName', '$commAblty', '$profAppr', " .
                            "'$compSkill', '$busnssKnow', '$interComment', '$recordDate')";
                        $result = mysqli_query($DBConnect, $sql);
                        if (!$result) {
                        } else { // data was able to be inputted
                            echo "<h3>Thank you for logging this interview!</h3>";
                            $interName = "";
                            $interPos = "";
                            $caniName = "";
                            $commAblty = "";
                            $profAppr = "";
                            $compSkill = "";
                            $busnssKnow = "";
                            $interComment = "";
                        }
                    }
                    mysqli_close($DBConnect); // necessary any time to ensure the database doesn't run out of ceonnections
                }
            }
        }
    }
    ?>
    <form action="InterviewResults.php" method="post">
        <fieldset>
            <section id="left">
                <p><strong>Interviewer's Name:</strong><br>
                    <input type="text" name="interName" value="<?php echo $interName; ?>"></p>
                <p><strong>Interviewer's Position:</strong><br>
                    <input type="text" name="interPos" value="<?php echo $interPos; ?>"></p>
                <p><strong>Canidate's Name:</strong><br>
                    <input type="text" name="caniName" value="<?php echo $caniName; ?>"></p>
                <p><strong>Communication Abilities:</strong><br>
                    <textarea rows="4" cols="25" name="commAblty"><?php echo $commAblty ?></textarea></p>
                <p><strong>Professional Appearance:</strong><br>
                    <textarea rows="4" cols="25" name="profAppr"><?php echo $profAppr ?></textarea></p>
            </section>
            <section id="right">
                <p><strong>Computer Skills:</strong><br>
                    <textarea rows="4" cols="25" name="compSkill"><?php echo $compSkill ?></textarea></p>
                <p><strong>Business Knowledge:</strong><br>
                    <textarea rows="4" cols="25" name="busnssKnow"><?php echo $busnssKnow ?></textarea></p>
                <p><strong>Interviewer's Comments:</strong><br>
                    <textarea rows="4" cols="25" name="interComment"><?php echo $interComment ?></textarea></p>
                <p><strong>Date of Interview:</strong><br>
                    <input type="date" name="recordDate">
            </section>
            <span>
                <p><input type="submit" name="submit" value="Submit"></p>
            </span>
        </fieldset>
    </form>
    <span>
        <p><a href="InterviewLog.php">View Logged Interviews</a></p>
    </span>
</body>

</html>
