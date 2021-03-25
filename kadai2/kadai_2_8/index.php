<!-- コメント書き込み処理 -->
<?php

/* 二重サブミット防止用 */
session_start();
$token = isset($_POST["token"]) ? $_POST["token"] : "";
$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
unset($_SESSION["token"]);

/* 編集モードの時の処理 */
if (!empty(($_POST['edit']))) {
    $_POST['edit'] = NULL;
    $edit_mode = NULL;

    require 'connect.php';

    $sql = "UPDATE COMMENTS SET comment = :comment WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $params = array(':comment' => $_POST['comment'], ':id' => $_POST['edit_number']);
    $stmt->execute($params);

    $dbh = null;
} else if ($token != "" && $token == $session_token) {
    /* 通常のコメント書き込み */
    require 'connect.php';

    $sql = "INSERT INTO COMMENTS (id, name, comment, password, datetime) VALUES (:id, :name, :comment, :password, now())";
    $id_max = intval($dbh->query("SELECT max(id) FROM COMMENTS")->fetchColumn());
    if (!isset($id_max)) {
        $comment_number = 1;
    } else {
        $comment_number = $id_max + 1;
    }
    $stmt = $dbh->prepare($sql);
    $params = array(':id' => $comment_number, ':name' => $_POST['name'], ':comment' => $_POST['comment'], ':password' => $_POST['password']);
    $stmt->execute($params);

    $dbh = null;
}
?>

<!-- コメント削除処理 -->
<?php

$delete_flag_token = isset($_POST["delete_flag"]) ? $_POST["delete_flag"] : "";
unset($_SESSION["token"]);
$delete_number = isset($_POST["delete_number"]) ? $_POST["delete_number"] : "";

if (isset($_POST['delete_flag']) && empty($delete_number)) {
    $alert = "<script type='text/javascript'>alert('番号が入力されていません。');</script>";
    echo $alert;
} else if ($delete_flag_token != "" && $delete_flag_token == $session_token) {
    require 'connect.php';

    $sql = "SELECT password FROM COMMENTS WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $params = array(':id' => $_POST['delete_number']);
    $stmt->execute($params);
    $password = $stmt->fetch(PDO::FETCH_COLUMN);
    if ($password != $_POST['delete_password']) {
        $alert = "<script type='text/javascript'>alert('パスワードが違います。');</script>";
        echo $alert;
        $dbh = null;
    } else {
        require 'connect.php';

        $sql = "DELETE FROM COMMENTS WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $params = array(':id' => $_POST['delete_number']);
        $stmt->execute($params);

        $dbh = null;
    }
}
?>

<!-- コメント編集処理 -->

<?php
$edit_flag_token = isset($_POST["edit_flag"]) ? $_POST["edit_flag"] : "";
unset($_SESSION["token"]);
$edit_number = isset($_POST["edit_number"]) ? $_POST["edit_number"] : "";

if (isset($_POST['edit_flag']) && empty($edit_number)) {
    $alert = "<script type='text/javascript'>alert('番号が入力されていません。');</script>";
    echo $alert;

} else if ($edit_flag_token != "" && $edit_flag_token == $session_token){
    require 'connect.php';

    $sql = "SELECT password FROM COMMENTS WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $params = array(':id' => $_POST['edit_number']);
    $stmt->execute($params);
    $password = $stmt->fetch(PDO::FETCH_COLUMN);
    if ($password != $_POST['edit_password']) {
        $alert = "<script type='text/javascript'>alert('パスワードが違います。');</script>";
        echo $alert;
        $dbh = null;

    } else {
        require 'connect.php';
        $edit_mode = 1;

        $sql = "SELECT * FROM COMMENTS WHERE id = $edit_number";
        $res = $dbh->query($sql);
        foreach ($res as $value) {
            $edit_name = "$value[name]";
            $edit_comment = "$value[comment]";
            $edit_password = "$value[password]";
        }

        $dbh = null;
    }
}
?>

<!-- 二重サブミット防止用 -->
<?php

$token = uniqid('', true);;
$_SESSION['token'] = $token;

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MySQLを使った掲示板">
    <title>簡易掲示板</title>
    <link href="https://fonts.googleapis.com/css?family=Sawarabi+Gothic" rel="stylesheet">
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <header>
        <div class="container">
            <h1 class="title">簡易掲示板</h1>
        </div>
    </header>

    <section class="main">
        <div class="main-left">
            <!-- コメント入力用フォーム -->
            <div class="comment-form">
                <h2 class="comment-form-title">
                    投稿
                </h2>
                <form action="index.php" method="post">
                    <input type="hidden" name="edit" value="<?php if (isset($edit_mode)) {
                                                                echo $edit_mode;
                                                            } ?>">
                    <input type="hidden" name="edit_number" value="<?php if (isset($edit_mode)) echo $edit_number; ?>">
                    名前：<br>
                    <input type="text" name="name" size="30" value="<?php if (isset($edit_mode)) echo $edit_name; ?>"><br>
                    パスワード：<br>
                    <input type="password" name="password" size="30" value="<?php if (isset($edit_mode)) echo $edit_password; ?>">
                    コメント：<br>
                    <textarea name="comment" cols="30" rows="5"><?php if (isset($edit_mode)) echo $edit_comment; ?></textarea><br>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <input type="submit" value="投稿する">
                </form>

            </div>

            <!-- コメント削除用フォーム -->
            <div class="delete-form">
                <h2 class="delete-form-title">
                    削除
                </h2>
                <form action="index.php" method="post">
                    番号：<br>
                    <input type="number" name="delete_number" min=1 value=""><br>
                    パスワード：<br>
                    <input type="password" name="delete_password" size="30">
                    <input type="hidden" name="delete_flag" value="<?php echo $token; ?>">
                    <input type="submit" value="削除する">
                </form>

            </div>

            <!-- コメント編集用フォーム -->
            <div class="edit-form">
                <h2 class="edit-form-title">
                    編集
                </h2>
                <form action="index.php" method="post">
                    番号：<br>
                    <input type="number" name="edit_number" min=1 value=""><br>
                    パスワード：<br>
                    <input type="password" name="edit_password" size="30">
                    <input type="hidden" name="edit_flag" value="<?php echo $token; ?>">
                    <input type="submit" value="編集する">
                </form>

            </div>
        </div>

        <!-- コメント表示欄 -->
        <div class="main-right">
            <h2 class="main-right-title">
                ～ コメント ～
            </h2>
            <div class="comment">
                <?php
                require 'connect.php';

                $sql = "SELECT * FROM COMMENTS";
                $res = $dbh->query($sql);
                foreach ($res as $value) {
                    echo "$value[id]" . ".\t" . "$value[name]" . "さん\t" . "$value[comment]" . "<br />";
                }

                $dbh = null;
                ?>
            </div>
        </div>
    </section>

</body>

</html>