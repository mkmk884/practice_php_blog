<html>
<head>
  <meta charset="utf-8">
  <title>はやしのブログサイト</title>
  <link rel="stylesheet" href="top.css" type="text/css"/>
</head>
<body>
  <div class="top" ><h1>はやしのブログ</h1></div>
  <p><a href="post.php">blog投稿ページはこちら</a></p>
  <?php
  try{
    $dbh = new PDO('sqlite:blog.db','','');
    $sth = $dbh->prepare("select * from posts order by id desc");
    $sth->execute();

    while ($row = $sth->fetch()) {
      $time = preg_split("/[\s.:-]+/",$row['date']);
      $editTime = preg_split("/[\s.:-]+/",$row['edit']);
      ?>
      <div class="post">
        <h3><?php echo $row['title']?></h3>
        <p><?php echo nl2br(htmlspecialchars($row["contents"])) ?><br>(投稿日時 <?php echo $time[0]."年".$time[1]."月". $time[2]."日 ".$time[3].":".$time[4] ?>)<br>
          <?php
          if(isset($row['edit'])){
            echo "(最終更新 ".$editTime[0]."年".$editTime[1]."月". $editTime[2]."日 ".$editTime[3].":".$editTime[4].")";
          }
          ?>
        </p>

        <form action = "edit.php" method = "post">
          <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
          <input type="submit" value="編集">
        </form>
      </div>

      <form action = "delete.php" method = "post">
        削除用パスワード：<input type="password" name="password" size="20" />
        <input type="submit" value="削除">
        <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
      </form>

      <h4>コメント：</h4>
      <?php
      $sth2 = $dbh->prepare("select * from comments where pid=? order by id desc");
      $sth2->execute(array($row['id']));
      while ($row2 = $sth2->fetch()) {
        $time = preg_split("/[\s.:-]+/",$row2['date']);?>
      <p>
      <div class="commentBalloon">
        <?php echo nl2br(htmlspecialchars($row2["contents"])) ?>
        by <?php echo $row2['user'] ?><br>
        (<?php echo $time[0]."年".$time[1]."月". $time[2]."日 ".$time[3].":".$time[4] ?>)<br><br>
        <form action = "deleteComment.php" method = "post">
          パスワード：<input type="password" name="password" size="20" />
          <input type="submit" value="削除">
          <input type="hidden" name="id" value="<?php echo $row2["id"] ?>">
        </form>
      </div>
      </p>
      <?php
      }
      ?>
      <form action="comment.php" method="post">
        <p>
          おなまえ：<input type="text" name="user" size="20" /><br>
          <textarea name="contents" rows="2" cols="50"></textarea><br>
          削除用パスワードを設定してください：<input type="password" name="password" size="20" />
          <input type="hidden" name="pid" value="<?php echo $row["id"] ?>">
          <input type="submit" value="投稿">
        </p>
      </form>

      <hr/>

  <?php
    }
  } Catch (PDOException $e) {
    print "エラー!: " . $e->getMessage() . "<br/>";
    die();
  }
  ?>
  </body>
</html>
