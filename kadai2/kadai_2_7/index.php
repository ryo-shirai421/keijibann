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
                <form action="comment.php" method="post">
                    <input type="hidden" name="edit" value="<?php if (isset($_POST['edit_mode'])) {
                                                                echo $_POST['edit_mode'];
                                                                $_POST['edit_mode'] = NULL;
                                                            } ?>">
                    <input type="hidden" name="edit_number" value="<?php if (isset($_POST['edit_number'])) echo $_POST['edit_number']; ?>">
                    名前：<br>
                    <input type="text" name="name" size="30" value="<?php if (isset($_POST['edit_name'])) echo $_POST['edit_name']; ?>"><br>
                    パスワード：<br>
                    <input type="password" name="password" size="30" value="<?php if (isset($_POST['edit_password'])) echo $_POST['edit_password']; ?>">
                    コメント：<br>
                    <textarea name="comment" cols="30" rows="5"><?php if (isset($_POST['edit_comment'])) echo $_POST['edit_comment']; ?></textarea><br>
                    <input type="submit" value="送信">
                </form>

            </div>

            <!-- コメント削除用フォーム -->
            <div class="delete-form">
                <h2 class="delete-form-title">
                    削除
                </h2>                                         
                <form action="delete.php" method="post">
                    番号：<br>
                    <input type="number" name="delete_number" min=1 value=""><br>
                    パスワード：<br>
                    <input type="password" name="delete_password" size="30">
                    <input type="submit" value="送信">
                </form>

            </div>

            <!-- コメント編集用フォーム -->
            <div class="edit-form">
                <h2 class="edit-form-title">
                    編集
                </h2>                                              
                <form action="edit.php" method="post">
                    番号：<br>
                    <input type="number" name="edit_number" min=1 value=""><br>
                    パスワード：<br>
                    <input type="password" name="edit_password" size="30">
                    <input type="submit" value="送信">
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