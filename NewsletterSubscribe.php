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
        $DBConnect = mysqli_connect($hostName, $userName, $password);
        
        if (!$DBConnect) { // inform if the database was able to be connected to
            echo "<p>Connection failed.</p>\n";
        } else {
            if (mysqli_select_db($DBConnect, $DBName)) { // attempts to connect to the database.  if it can, inform the user, otherwise give a reason.
                echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
            } else {
                echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . ".</p>\n";
            }
            mysqli_close($DBConnect);
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
