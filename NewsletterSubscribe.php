<!doctype html>

<html>

<!--
    
    Exercise 02.08.01
    
    Author: Abraham Aguilar
    Date: 11.01.18
    
    NewsletterSubscribe.php
    
-->

<head>
    <title>Newsletter Subscribe</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h2>Newsletter Subscribe</h2>
    <?php
    $hostName = "localhost";
    $userName = "adminer";
    $password = "hurry-leave-06";
    $DBName = "newsletter2";
    $tableName = "subscribers";
    $subscriberName = "";
    $subscriberEmail = "";
    $showForm = false;
    
    if (isset($_POST['submit'])) { // if the form was submitted, run the code within the if
        $formErrorcount = 0;
        
        if (!empty($_POST['subName'])) { // checks for an empty name
            $subscriberName = stripslashes($_POST['subName']);
            $subscriberName = trim($subscriberName);
            
            if (strlen($subscriberName) === 0) { // checks for only spaces in the name
                echo "<p>You must include your <strong>name</strong>.</p>\n";
                ++$formErrorcount;
            }
        } else {
            echo "<p>Form submittal error, no <strong>name</strong> field.</p>\n";
            ++$formErrorcount;
        }
        if (!empty($_POST['subEmail'])) { // checks for an empty email
            $subscriberEmail = stripslashes($_POST['subEmail']);
            $subscriberEmail = trim($subscriberEmail);
            
            if (strlen($subscriberEmail) === 0) { // checks for only spaces in the email
                echo "<p>You must include your <strong>email</strong>.</p>\n";
                ++$formErrorcount;
            }
        } else {
            echo "<p>Form submittal error, no <strong>email</strong> field.</p>\n";
            ++$formErrorcount;
        }
        if ($formErrorcount == 0) { // checks for if there are no errors.
            $showForm = false;
            $DBConnect = mysqli_connect($hostName, $userName, $password);
            
            if (!$DBConnect) { // inform if the database was able to be connected to
                echo "<p>Connection error: " . mysqli_connect_error($DBConnect) . "</p>\n";
            } else {
                if (mysqli_select_db($DBConnect, $DBName)) { // attempts to connect to the database.  if it can, inform the user, otherwise give a reason.
                    echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
                    $subscriberDate = date("Y-m-d");
                    $sql = "INSERT INTO $tableName (name, email, subscribeDate) VALUES ('$subscriberName', '$subscriberEmail', '$subscriberDate')";
                    $results = mysqli_query($DBConnect, $sql);
                    
                    if (!$results) {
                        echo "<p>Unable to insert the values into the <strong>$tableName</strong> table.</p>\n";
                    } else {
                        $subscriberID = mysqli_insert_id($DBConnect);
                        echo "<p><strong>" . htmlentities($subscriberName) . "</strong>, you are now subscribed to our newsletter.<br>";
                        echo "Your subscriber ID is <strong>$subscriberID</strong>.<br>";
                        echo "Your email address is <strong>" . htmlentities($subscriberEmail) . "</strong>.</p>";
                    }
                } else {
                    echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . ".</p>\n";
                }
                mysqli_close($DBConnect);
            }
        } else {
            $showForm = true;
        }
    } else {
        $showForm = true;
    }
    
    
    
    if ($showForm) { //shows if there's an error or if it wasn't reached by submit
    ?>
    <form action="NewsletterSubscribe.php" method="post">
        <p><strong>Your Name:</strong><br>
            <input type="text" name="subName" value="<?php echo $subscriberName; ?>"></p>
        <p><strong>Your E-mail Address:</strong><br>
            <input type="email" name="subEmail" value="<?php echo $subscriberEmail; ?>"></p>
        <p><input type="submit" name="submit" value="Submit"></p>
    </form>
</body>

</html>
<?php
}
?>
