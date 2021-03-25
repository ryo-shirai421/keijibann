<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フォーム確認</title>
    <link rel="icon" href="favicon.ico">
</head>
<body>

<!-- 編集モードの時の処理 -->
    <?php
        if(($_POST['edit']) != "") {
            $_POST['edit'] = NULL;
            
            require 'connect.php';

            $sql = "UPDATE COMMENTS SET comment = :comment WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $params = array(':comment' => $_POST['comment'], ':id' => $_POST['edit_number']);
            $stmt->execute($params);

            $dbh = null;
    ?>
        <a href="index.php">書き込む</a>
    <?php
        } else {
    ?>

    <!-- 通常のコメント書き込み -->
    <?php
            require 'connect.php';

            $sql = "INSERT INTO COMMENTS (id, name, comment, password, datetime) VALUES (:id, :name, :comment, :password, now())";
            $id_max = intval($dbh->query("SELECT max(id) FROM COMMENTS")->fetchColumn());
            if(!isset($id_max)){ $comment_number = 1;} else {$comment_number = $id_max + 1;}
            $stmt = $dbh->prepare($sql);
            $params = array(':id' => $comment_number, ':name' => $_POST['name'], ':comment' => $_POST['comment'], ':password' => $_POST['password']);
            $stmt->execute($params);

            $dbh = null;
    ?>
        <a href="index.php">コメント入力へ</a>
    <?php
        }
    ?>
</body>
</html>