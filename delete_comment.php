<?php
// 投稿IDおよびコメントIDを取得
$postId = isset($_GET['postId']) ? $_GET['postId'] : die('投稿IDが指定されていません。');
$commentId = isset($_GET['commentId']) ? $_GET['commentId'] : die('コメントIDが指定されていません。');

// コメントファイルの読み込み
$commentFile = "comments_$postId.txt";
if (file_exists($commentFile)) {
    $comments = file($commentFile);

    // コメントを削除
    unset($comments[$commentId]);

    // 削除後のコメントデータを保存
    file_put_contents($commentFile, implode("", $comments));

    // コメントが空になった場合はコメントファイルも削除
    if (empty($comments)) {
      unlink($commentFile);
  }
}

// 投稿詳細画面にリダイレクト
header("Location: post_detail.php?id=$postId");
exit();
?>
