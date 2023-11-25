<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel News</title>
</head>

<body>
  <h1>Laravel News</h1>

  <form action="index.php" method="post">
    <label for="title">タイトル:</label>
    <input type="text" name="title" required>
    <br>
    <label for="message">投稿内容:</label>
    <textarea name="message" rows="4" required></textarea>
    <br>
    <input type="submit" value="投稿">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $message = $_POST["message"];
    $post = "$title: $message\n";
    file_put_contents('posts.txt', $post, FILE_APPEND);
  }

  if (file_exists('posts.txt')) {
    $posts = file('posts.txt');
    echo "<h2>投稿一覧</h2>";
    $postId = 0;
    while ($postId < count($posts)) {
      $post = $posts[$postId];
      echo "<p><a href='post_detail.php?id=$postId'>$post</a><a href='delete_post.php?postId=$postId'>[削除]</a></p>";
      $postId++;
    }
  }
  ?>
</body>

</html>