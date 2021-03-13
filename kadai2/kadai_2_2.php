<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フォーム確認</title>
</head>
<body>
    <?php
        $fp = fopen("test1.txt", "a+");
        for ($count=0; fgets($fp); $count++);
        $comment_number = $count + 1;
        $text = $comment_number."<>".$_POST["name"]."<>".$_POST["comment"]."<>".date('Y-m-d')."\n";
        fwrite($fp, $text);
        $count++;
        fclose($fp);
    ?>
    <a href="kadai_2_3.php">コメント入力へ</a>
</body>
</html>