<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ブログ記事へのコメント</title>
    <link rel="stylesheet" href="comment.css" type="text/css"/>
  </head>
  <body>
    <div class="top" ><h1>はやしのブログ</h1></div>
    <h2>コメント投稿</h2>
    <?php
    try {
      ini_set("date.timezone", "Asia/Tokyo");
      $time=date("Y.m.d-H:i");

      $dbh = new PDO('sqlite:blog.db','','');

      if (isset($_POST["contents"])) {
        $sql = 'insert into comments (pid,contents,date,user,password) values (?, ?, ?, ?, ?)';
        $sth = $dbh->prepare($sql);
        $sth->execute(array($_POST["pid"], $_POST["contents"], $time, $_POST["user"], $_POST["password"]));

        if ($sth) {
          echo "コメント１件を投稿しました";
        } else {
          echo "コメント１件の投稿に失敗しました";
        }
      }

      $dbh = null;

    } Catch (PDOException $e) {
      print "エラー!: " . $e->getMessage() . "<br/>";
      die();
    }

   ?>

    <p><a href="index.php">blog閲覧ページはこちら</a></p>
  </body>
</html>
