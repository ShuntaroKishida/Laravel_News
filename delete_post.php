<?php
if (isset($_GET['postId'])) {
  $postId = $_GET['postId'];
} else {
  die('投稿IDが指定されていません。');
}

$postFile = 'posts.txt';
if (file_exists($postFile)) {
    $posts = file($postFile);

    unset($posts[$postId]);
    file_put_contents($postFile, implode("", $posts));

    $commentFile = "comments_$postId.txt";
    if (file_exists($commentFile)) {
        unlink($commentFile);
    }
}

header("Location: index.php");
exit();
?>
