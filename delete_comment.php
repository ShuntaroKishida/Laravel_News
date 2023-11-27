<?php
if (isset($_GET['postId'])) {
  $postId = $_GET['postId'];
} else {
  die('投稿IDが指定されていません。');
}

if (isset($_GET['commentId'])) {
  $commentId = $_GET['commentId'];
} else {
  die('コメントIDが指定されていません。');
}

$commentFile = "comments_$postId.txt";

if (file_exists($commentFile)) {
  $comments = file($commentFile);
  $found = false;
  $commentIndex = 0;

  while ($commentIndex < count($comments)) {
    $comment = $comments[$commentIndex];
    list($currentCommentId, $comment) = explode(':', $comment, 2);

    if ($currentCommentId == $commentId) {
      $found = true;
      unset($comments[$commentIndex]);
      file_put_contents($commentFile, implode("", $comments));

      if (empty($comments)) {
        unlink($commentFile);
      }

      header("Location: post_detail.php?postId=$postId");
      exit();
    }

    $commentIndex++;
  }

  if (!$found) {
    die('コメントが見つかりません。');
  }
}
