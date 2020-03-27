<?php
include_once 'Config.php';
include_once 'User.php'
?>
<!DOCTYPE html>
<html>

<head>
    <title>DB Con Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="myscripts.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Test af DB connection</h1>
    <h4>Current users in database</h4>

    <?php
    //connect to the DB -> if connection failed it will show on the page
    $object = new Dbh;
    $object->connect();
    //print users
    $object = new User;
    echo $object->getAllUsers();
    ?>

</body>

</html>