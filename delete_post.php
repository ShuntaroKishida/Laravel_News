<?php
// 投稿IDを取得
$postId = isset($_GET['postId']) ? $_GET['postId'] : die('投稿IDが指定されていません。');

// 投稿ファイルの読み込み
$postFile = 'posts.txt';
if (file_exists($postFile)) {
    $posts = file($postFile);

    // 投稿を削除
    unset($posts[$postId]);

    // 削除後の投稿データを保存
    file_put_contents($postFile, implode("", $posts));
}

// index.phpにリダイレクト
header("Location: index.php");
exit();
?>
