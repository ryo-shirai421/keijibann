<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>削除番号確認</title>
    <link rel="icon" href="favicon.ico">
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
            require 'connect.php';

            $sql = "SELECT password FROM COMMENTS WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $params = array(':id'=> $_POST['delete_number']);
            $stmt->execute($params);
            $password = $stmt->fetch(PDO::FETCH_COLUMN);
            if($password != $_POST['delete_password']) {
                echo "入力されたパスワードが正しくありません。";
                $dbh = null;
    ?>
        <br><button type="button" onclick="history.back()">戻る</button>

    <?php
            } else {
                require 'connect.php';

                $sql = "DELETE FROM COMMENTS WHERE id = :id";
                $stmt = $dbh->prepare($sql);
                $params = array(':id'=> $_POST['delete_number']);
                $stmt->execute($params);

                $dbh = null;
    ?>
        <a href="index.php">掲示板へ</a>
    <?php 
            }
        }
    ?>
</body>
</html>