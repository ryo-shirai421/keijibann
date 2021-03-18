<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フォーム確認</title>
</head>
<body>

<!-- 編集モードの時の処理 -->
    <?php
        if(($_POST['edit']) != "") {
            $_POST['edit'] = NULL;
            
            require 'connect.php';

            $sql = "UPDATE comments SET comment = :comment WHERE id = :id";
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

            $sql = "INSERT INTO comments (id, name, comment, password, datetime) VALUES (:id, :name, :comment, :password, now())";
            //$id_max = intval($pdo->query("SELECT max(id) FROM comments")->fetchColumn());
            $comment_number = 1;
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