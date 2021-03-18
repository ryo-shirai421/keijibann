<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MySQLを使った掲示板">
    <title>簡易掲示板</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- コメント入力用フォーム -->
    <form action="comment.php" method="post">
        <input type="hidden" name="edit" value="<?php if(isset($_POST['edit_mode'])) {echo $_POST['edit_mode']; $_POST['edit_mode'] = NULL;}?>">
        <input type="hidden" name="edit_number" value="<?php if(isset($_POST['edit_number'])) echo $_POST['edit_number'];?>">
        名前：<br>
        <input type="text" name="name" size="30" value="<?php if(isset($_POST['edit_name'])) echo $_POST['edit_name'];?>"><br>
        パスワード：<br>
        <input type="password" name="password" size="30" value="<?php if(isset($_POST['edit_password'])) echo $_POST['edit_password'];?>"><br>
        コメント：<br>
        <textarea name="comment" cols="30" rows="5"><?php if(isset($_POST['edit_comment'])) echo $_POST['edit_comment'];?></textarea><br>
        <input type="submit" value="送信">
    </form>
    <br>

<!-- コメント削除用フォーム -->
    <form action="delete.php" method="post">
        削除したい番号とパスワードを入力してください:<br>
        番号：<br>
        <input type="number" name="delete_number" min=1 value=""><br>
        パスワード：<br>
        <input type="password" name="delete_password" size="30">
        <input type="submit" value="送信">
    </form>

<!-- コメント編集用フォーム -->
    <form action="edit.php" method="post">
        編集したい番号とパスワードを入力してください:<br>
        番号：<br>
        <input type="number" name="edit_number" min=1 value=""><br>
        パスワード：<br>
        <input type="password" name="edit_password1" size="30">
        <input type="submit" value="送信">
    </form>

<!-- コメント表示欄 -->
    <div>
        <br>
        <?php
            require 'connect.php';

            $sql = "SELECT * FROM comments";
            $res = $dbh->query($sql);
            foreach( $res as $value ) {
		        echo "$value[id]".".\t"."$value[name]"."さん\t"."$value[comment]"."<br />";
	        }

            $dbh = null;
        ?>
    </div>

</body>
</html>