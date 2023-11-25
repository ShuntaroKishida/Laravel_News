<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel News</title>
</head>

<body>
  <?php
  if (isset($_GET['id'])) {
    $postId = $_GET['id'];
  } else {
    die('投稿IDが指定されていません。');
  }
  echo "<p><a href='index.php'><h1>Laravel News</h1></a></p>";

  if (file_exists('posts.txt')) {
    $posts = file('posts.txt');
    if (isset($posts[$postId])) {
      $post = $posts[$postId];
      echo "<h2>投稿詳細</h2>";
      echo "<pre>$post</pre>";
    } else {
      die('投稿が見つかりません。');
    }
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["comment"])) {
      $comment = $_POST["comment"];
    } else {
      $comment = '';
    }

    $commentData = "- $comment\n";
    $commentFile = "comments_$postId.txt";
    file_put_contents($commentFile, $commentData, FILE_APPEND);
  }

  $commentFile = "comments_$postId.txt";

  if (file_exists($commentFile)) {
    $comments = file($commentFile);
    echo "<h2>コメント一覧</h2>";

    $commentId = 0;

    while ($commentId < count($comments)) {
      $comment = $comments[$commentId];
      echo "<p>$comment <a href='delete_comment.php?postId=$postId&commentId=$commentId'>[削除]</a></p>";
      $commentId++;
    }
  }
  ?>

  <h2>コメント投稿</h2>
  <form action="post_detail.php?id=<?php echo $postId; ?>" method="post">
    <label for="comment">コメント:</label>
    <textarea name="comment" rows="4" required></textarea>
    <br>
    <input type="submit" value="コメント投稿">
  </form>
</body>

</html>