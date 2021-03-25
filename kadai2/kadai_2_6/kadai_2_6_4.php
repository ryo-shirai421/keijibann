<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集用</title>
</head>
<body>
    <?php
        $edit_number = $_POST["edit_number"];
        if(empty($edit_number)) {
            echo "データが入力されていません。編集したい番号を入力してください。";
    ?>
        <br><button type="button" onclick="history.back()">戻る</button>
    <?php
        } else {
            $file_name = "test1.txt";
            $ret_array = file($file_name);
            for( $i = 0; $i < count($ret_array); ++$i ) {
                $parts = explode("<>", $ret_array[$i]);
                if($parts[0] == $edit_number) {
                    $edit_name = $parts[1];
                    $edit_comment = $parts[2];
                    $edit_password = $parts[3];
                }
            }
        }

        if($_POST['edit_password1'] != $edit_password) {
            echo "誤ったパスワードです。";
    ?>
        <br><button type="button" onclick="history.back()">戻る</button>
    <?php
        } else {
    ?>
    <form action="kadai_2_6_1.php" method ="post">
        <input type="hidden" name="edit_name" value="<?php echo $edit_name?>">
        <input type="hidden" name="edit_comment" value="<?php echo $edit_comment?>">
        <input type="hidden" name="edit_number" value="<?php echo $edit_number?>">
        <input type="hidden" name="edit_password" value="<?php echo $edit_password?>">
        <input type="hidden" name="edit_mode" value="<?php echo 1?>">
        <input type="submit" value="編集する">
    </form>
    <?php
        }
    ?>
</body>
</html>