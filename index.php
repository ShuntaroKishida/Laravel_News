<?php
$error = '';
$postAll = '';
$postDetail = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $postId = $_POST["postId"];
  $title = $_POST["title"];
  $message = $_POST["message"];

  if (mb_strlen($title) > 30) {
    $error = "タイトルは30文字以下で入力してください。";
  } else if (mb_strlen($title) === 0) {
    $error = "タイトルは必須です。";
  } else if (mb_strlen($message) === 0) {
    $error = "投稿内容は必須です。";
  } else {
    $postId = time();
    $post = "$postId: $title: $message\n";
    file_put_contents('posts.txt', $post, FILE_APPEND);
  }

  header("Location: index.php");
  exit();
}

if (file_exists('posts.txt')) {
  $posts = file('posts.txt');
  $postAll = "<h2>投稿一覧</h2>";

  $postId = 0;
  while ($postId < count($posts)) {
    $currentPost = $posts[$postId];
    $postElements = explode(':', $currentPost, 3);
    
    if (count($postElements) < 3) {
      $postId++;
      continue;
    }

    list($currentPostId, $title, $message) = $postElements;
    $deletePost = "<p><a>$title: $message</a><a href='delete_post.php?postId=$currentPostId'>[削除]</a></p>";
    $detailPost = "<p><a href='post_detail.php?postId=$currentPostId'>→記事全文・コメントを読む</a></p>";
    $postDetail .= $deletePost . $detailPost;
    $postId++;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel News</title>
  <script src="./script.js" defer></script>
</head>

<body>
  <h1>Laravel News</h1>

  <form id="myForm" action="index.php" method="post">
    <label for="title">タイトル:</label>
    <input type="text" name="title">
    <br>
    <label for="message">投稿内容:</label>
    <textarea name="message" rows="4"></textarea>
    <br>
    <input type="hidden" name="postId" value="<?php echo $postId; ?>">
    <input type="submit" value="投稿" onclick="confirmSubmission()">
  </form>

  <?php echo $error; ?>
  <?php echo $postAll; ?>
  <?php echo $postDetail; ?>

</body>

</html>