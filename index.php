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
    // 投稿処理
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST["title"];
        $message = $_POST["message"];

        // 投稿データを保存
        $post = "$title: $message\n";
        file_put_contents('posts.txt', $post, FILE_APPEND);
    }

    // 投稿一覧表示
    if (file_exists('posts.txt')) {
        $posts = file('posts.txt');
        echo "<h2>投稿一覧</h2>";
        foreach ($posts as $postId => $post) {
            // 各投稿のタイトルと削除リンクを表示
            echo "<p><a href='post_detail.php?id=$postId'>$post</a><a href='delete_post.php?postId=$postId'>[削除]</a></p>";
        }
    }
    ?>
</body>
</html>
