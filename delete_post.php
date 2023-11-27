<?php
if (isset($_GET['postId'])) {
  $postId = $_GET['postId'];
} else {
  die('投稿IDが指定されていません。');
}

$postFile = 'posts.txt';

if (file_exists($postFile)) {
  $posts = file($postFile);
  $found = false;
  $postIndex = 0;

  while ($postIndex < count($posts)) {
    $post = $posts[$postIndex];
    list($currentPostId, $title, $message) = explode(':', $post, 3);

    if ($currentPostId == $postId) {
      $found = true;
      unset($posts[$postIndex]);
      file_put_contents($postFile, implode("", $posts));

      $commentFile = "comments_$postId.txt";
      if (file_exists($commentFile)) {
        unlink($commentFile);
      }

      header("Location: index.php");
      exit();
    }

    $postIndex++;
  }

  if (!$found) {
    die('投稿が見つかりません。');
  }
}
