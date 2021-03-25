<!-- テーブル作成のプログラム -->

<?php
    require 'connect.php';

    $sql = "CREATE TABLE COMMENTS (
        id INT(11),
        name NCHAR(20),
        comment NCHAR(20),
        password NCHAR(20),
        datetime DATETIME
        )";

    $stmt = $dbh->query($sql);
    $dbh = null;
?>