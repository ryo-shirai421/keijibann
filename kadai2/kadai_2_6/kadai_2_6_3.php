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
        if(($_POST['edit']) != "") {
            $_POST['edit'] = NULL;
            $edit_number = $_POST['edit_number'];
            $file_name = "test1.txt";
            $fp_temp = fopen("test2.txt", "w");
            $ret_array = file($file_name);
            for( $i = 0; $i < count($ret_array); ++$i ) {
                $parts = explode("<>", $ret_array[$i]);
                if($parts[0] == $edit_number) {
                    $text = $edit_number."<>".$_POST['name']."<>".$_POST['comment']."<>".$_POST["password"]."<>".date('Y-m-d')."<>"."\n";
                    fwrite($fp_temp, $text);
                } else {
                    $text = $parts[0]."<>".$parts[1]."<>".$parts[2]."<>".$parts[3]."<>".$parts[4]."<>"."\n";
                    fwrite($fp_temp, $text);
                }
            }
            fclose($fp_temp);
            copy("test2.txt", "test1.txt");
            ?>
            <a href="kadai_2_6_1.php">書き込む</a>
            <?php
        } else {
    ?>
    <?php
            $fp = fopen("test1.txt", "a+");
            $file_name = "test1.txt";
            $ret_array = file($file_name);
            for( $i = 0; $i < count($ret_array); ++$i ) {
                $parts = explode("<>", $ret_array[$i]);
                $comment_number = $parts[0];
            }
            $comment_number++;
            $text = $comment_number."<>".$_POST["name"]."<>".$_POST["comment"]."<>".$_POST["password"]."<>".date('Y-m-d')."<>"."\n";
            fwrite($fp, $text);
            fclose($fp);
    ?>
        <a href="kadai_2_6_1.php">コメント入力へ</a>
    <?php
        }
    ?>
</body>
</html>