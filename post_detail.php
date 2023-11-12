<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel News</title>
</head>
<body>
    <?php
    // 投稿IDを取得
    $postId = isset($_GET['id']) ? $_GET['id'] : die('投稿IDが指定されていません。');

    // Laravel Newsへのリンク
    echo "<p><a href='index.php'><h1>Laravel News</h1></a></p>";

    // 投稿詳細表示
    if (file_exists('posts.txt')) {
        $posts = file('posts.txt');
        $post = isset($posts[$postId]) ? $posts[$postId] : die('投稿が見つかりません。');

        echo "<h2>投稿詳細</h2>";
        echo "<pre>$post</pre>";
    }

    // コメント投稿処理
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $comment = isset($_POST["comment"]) ? $_POST["comment"] : '';

        // コメントデータを保存
        $commentData = "- $comment\n";
        $commentFile = "comments_$postId.txt";
        file_put_contents($commentFile, $commentData, FILE_APPEND);
    }

    // コメント一覧表示
    $commentFile = "comments_$postId.txt";
    if (file_exists($commentFile)) {
        $comments = file($commentFile);
        echo "<h2>コメント一覧</h2>";
        foreach ($comments as $commentId => $comment) {
            // 各コメントと削除リンクを表示
            echo "<p>$comment <a href='delete_comment.php?postId=$postId&commentId=$commentId'>[削除]</a></p>";
        }
    }
    ?>

    <!-- コメント投稿フォーム -->
    <h2>コメント投稿</h2>
    <form action="post_detail.php?id=<?php echo $postId; ?>" method="post">
        <label for="comment">コメント:</label>
        <textarea name="comment" rows="4" required></textarea>
        <br>
        <input type="submit" value="コメント投稿">
    </form>
</body>
</html>
