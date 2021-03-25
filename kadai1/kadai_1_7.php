<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $file_name = "test3.txt";
        $ret_array = file( $file_name);
        for( $i = 0; $i < count($ret_array); ++$i ) {
            echo( $ret_array[$i] . "<br />\n" );
        }
    ?>
</body>
</html>