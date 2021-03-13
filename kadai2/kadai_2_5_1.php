<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡易掲示板</title>
</head>
<body>
    <form action="kadai_2_5_3.php" method="post">
        <input type="hidden" name="edit" value="<?php if(isset($_POST['edit_mode'])) {echo $_POST['edit_mode']; $_POST['edit_mode'] = NULL;} else echo NULL?>">
        <input type="hidden" name="edit_number" value="<?php if(isset($_POST['edit_number'])) echo $_POST['edit_number'];?>">
        名前：<br>
        <input type="text" name="name" size="30" value="<?php if(isset($_POST['edit_name'])) echo $_POST['edit_name'];?>"><br>
        コメント：<br>
        <textarea name="comment" cols="30" rows="5"><?php if(isset($_POST['edit_comment'])) echo $_POST['edit_comment'];?></textarea><br>
        <input type="submit" value="送信">
    </form>
    <br>
    <form action="kadai_2_5_2.php" method="post">
        削除したい番号を入力してください:<br>
        <input type="number" name="delete_number" min=1 value=""><br>
        <input type="submit" value="送信">
    </form>
    <form action="kadai_2_5_4.php" method="post">
        編集したい番号を入力してください:<br>
        <input type="number" name="edit_number" min=1 value=""><br>
        <input type="submit" value="送信">
    </form>
    <div>
        <br>
        <?php
            $file_name = "test1.txt";
            $ret_array = file($file_name);
            for( $i = 0; $i < count($ret_array); ++$i ) {
                $parts = explode("<>", $ret_array[$i]);
                echo "\t".$parts[0].".\t".$parts[1]."さん\t".$parts[2]."<br />";
            }
        ?>
    </div>
</body>
</html>