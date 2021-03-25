<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>削除番号確認</title>
</head>
<body>
    <?php
        $delete_number = $_POST["delete_number"];
        if(empty($delete_number)) {
            echo "データが入力されていません。削除したい番号を入力してください。";
    ?>
        <br><button type="button" onclick="history.back()">戻る</button>
    <?php 
        } else {
            $file_name = "test1.txt";
            $fp_temp = fopen("test2.txt", "w");
            $ret_array = file($file_name);

            for( $i = 0; $i < count($ret_array); ++$i ) {
                $parts = explode("<>", $ret_array[$i]);
                if($parts[0] != $delete_number) {
                    $text = $parts[0]."<>".$parts[1]."<>".$parts[2]."<>".$parts[3]."<>".$parts[4]."<>"."\n";
                    fwrite($fp_temp, $text);
                }
            }
            fclose($fp_temp);
            copy("test2.txt", "test1.txt");
    ?>
        <a href="kadai_2_6_1.php">掲示板へ</a>
    <?php 
        }
    ?>
</body>
</html>