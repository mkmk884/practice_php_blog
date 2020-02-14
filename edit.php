<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ブログ記事の編集</title>
    <link rel="stylesheet" href="edit.css" type="text/css"/>
  </head>
  <body>
    <div class="top" ><h1>はやしのブログ</h1></div>
    <h2>ブログ記事の編集</h2>
    <?php
    try {
        $dbh = new PDO('sqlite:blog.db','','');
        ini_set("date.timezone", "Asia/Tokyo");
        $time = date("Y.m.d-H:i");

         if (isset($_POST["id"]) && !isset($_POST["title"]) && !isset($_POST["contents"])) {
           $sql = 'select * from posts where id=?';
           $sth = $dbh->prepare($sql);
           $sth->execute(array($_POST["id"]));
           if ($row = $sth->fetch()) {
               $_POST["title"] = $row['title'];
               $_POST["contents"] = $row['contents'];
           }
         } elseif (isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["contents"])) {
           if (!isset($_POST["password"]) || $_POST["password"] != '884') {
             echo '<p>パスワードが違います</p>';
           }
           else {
             $sql = 'update posts set title=?, contents=?, edit=? where id=?';
             $sth = $dbh->prepare($sql);
             $sth->execute(array($_POST["title"], $_POST["contents"], $time, $_POST["id"]));
             if ($sth) {
               echo "記事１件を更新しました";
             } else {
               echo "記事１件の更新に失敗しました";
             }
           }
         }
         $dbh = null;
       } Catch (PDOException $e) {
         print "エラー!: " . $e->getMessage() . "<br/>";
         die();
       }

   ?>

    <p><a href="index.php">blog閲覧ページはこちら</a></p>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <dl>
        <dt>表題：</dt>
        <dd><input type="text" name="title" value="<?php echo $_POST["title"] ?>" size="60" /></dd>
        <dt>本文：</dt>
        <dd><textarea name="contents" rows="10" cols="60"><?php echo $_POST["contents"] ?></textarea></dd>
        <dt>パスワード：</dt>
        <dd><input type="password" name="password" size="20" /></dd>
      </dl>
      <input type="hidden" name="id" value="<?php echo $_POST["id"] ?>" />
      <input type="reset" value="リセット" />
      <input type="submit" value="送信" />
    </form>
  </body>
</html>
