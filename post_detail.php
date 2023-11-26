<?php
$error = '';
$post_detail_title = '';
$post_detail = '';
$commentAll = '';
$deleteComment = '';

if (isset($_GET['id'])) {
  $postId = $_GET['id'];
} else if (isset($_POST['postId'])) {
  $postId = $_POST['postId'];
} else {
  die('投稿IDが指定されていません。');
}

if (file_exists('posts.txt')) {
  $posts = file('posts.txt');
  if (isset($posts[$postId])) {
    $post = $posts[$postId];
    $post_detail_title = "<h2>投稿詳細</h2>";
    $post_detail = "<pre>$post</pre>";
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

  if (mb_strlen($comment) > 50) {
    $error = "コメントは50文字以下で入力してください。";
  } else if (mb_strlen($comment) === 0) {
    $error = "コメント内容は必須です。";
  } else {
    $commentData = "$comment\n";
    $commentFile = "comments_$postId.txt";
    file_put_contents($commentFile, $commentData, FILE_APPEND);
  }

  header("Location: post_detail.php?id=$postId");
  exit();
}

$commentFile = "comments_$postId.txt";

if (file_exists($commentFile)) {
  $comments = file($commentFile);
  $commentAll = "<h2>コメント一覧</h2>";

  $commentId = 0;
  while ($commentId < count($comments)) {
    $comment = $comments[$commentId];
    $deleteComment .= "<p>$comment <a href='delete_comment.php?postId=$postId&commentId=$commentId'>[削除]</a></p>";
    $commentId++;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel News</title>
</head>

<body>
  <p><a href='index.php'>
      <h1>Laravel News</h1>
    </a></p>
  <?php echo $post_detail_title; ?>
  <?php echo $post_detail; ?>

  <h2>コメント投稿</h2>
  <form action="post_detail.php?id=<?php echo $postId; ?>" method="post">
    <label for="comment">コメント:</label>
    <textarea name="comment" rows="4"></textarea>
    <br>
    <input type="submit" value="コメント投稿">
  </form>
  <?php echo $error; ?>

  <?php echo $commentAll; ?>
  <?php echo $deleteComment; ?>

</body>

</html>