<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シンプルなツイート投稿アプリ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>ツイート投稿アプリ</h1>

<!-- ツイート投稿フォーム -->
<form method="post" action="index.php">
    <label for="tweet">ツイート内容:</label>
    <input type="text" id="tweet" name="tweet" required>
    <button type="submit">投稿</button>
</form>

<?php
// ツイートをテキストファイルに保存
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tweet = $_POST["tweet"];
    $file = "tweets.txt";

    // ファイルにツイートを追記
    $currentTweets = file_get_contents($file);
    $currentTweets .= $tweet . "\n";
    file_put_contents($file, $currentTweets);

    echo "<p>ツイートが保存されました。</p>";
}

// ツイート一覧を表示
$file = "tweets.txt";
if (file_exists($file)) {
    echo "<h2>ツイート一覧</h2>";
    $tweets = file_get_contents($file);
    $tweetArray = explode("\n", $tweets);

    foreach ($tweetArray as $tweet) {
        if (!empty($tweet)) {
            echo "<p>" . $tweet . "</p>";
        }
    }
} else {
    echo "<p>まだツイートはありません。</p>";
}
?>

</body>
</html>
