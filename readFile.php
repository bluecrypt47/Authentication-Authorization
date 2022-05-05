<?php
require 'handle.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read file</title>
</head>

<body>
    <?php
    if (isset($_GET['readFile'])) {
        $filename = './uploads/' . $_GET['readFile'];
        $fp = fopen($filename, "r");

        $contents = fread($fp, filesize($filename));

        echo "<pre>$contents</pre>";
        fclose($fp);
    }
    ?>
</body>

</html>