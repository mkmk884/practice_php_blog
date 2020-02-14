<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ブログ記事の削除</title>
    <link rel="stylesheet" href="delete.css" type="text/css"/>
  </head>
  <body>
    <div class="top" ><h1>はやしのブログ</h1></div>
    <h2>ブログ記事の削除</h2>
    <?php
	  try {

      $dbh = new PDO('sqlite:blog.db','','');

      if (isset($_POST["id"])) {
        if (!isset($_POST["password"]) || $_POST["password"] != '884') {
          echo '<p>パスワードが違います</p>';
        }
        else {
          $sql = 'delete from posts where id=?';
          $sth = $dbh->prepare($sql);
          $sth->execute(array($_POST["id"]));

          if ($sth) {
            echo "記事１件を削除しました";
          } else {
            echo "記事１件の削除に失敗しました";
          }
        }
      }

      $dbh = null;

      } Catch (PDOException $e) {
        print "エラー!: " . $e->getMessage() . "<br/>";
        die();
      }

   ?>

    <p><a href = "index.php">blog閲覧ページはこちら</a></p>
  </body>
</html>
