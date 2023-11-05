<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel News</title>
  <script>
    function confirmSubmit() {
      return confirm("投稿しますか？");
    }
  </script>
</head>

<body>

  <div class="container">
    <h1>Laravel News</h1>

    <!-- ツイート投稿フォーム -->
    <form method="post" action="index.php" onsubmit="return confirmSubmit();">
      <label for="title">タイトル (最大30文字):</label>
      <input type="text" id="title" name="title" maxlength="30" required><br>
      <label for="tweet">ツイート内容:</label>
      <input type="text" id="tweet" name="tweet" required><br>
      <button type="submit">投稿</button>
    </form>

    <?php
    // ツイートをテキストファイルに保存
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $title = $_POST["title"];
      $tweet = $_POST["tweet"];
      $file = "tweets.txt";

      // ファイルにツイートを追記
      $currentTweets = file_get_contents($file);
      $currentTweets .= "タイトル: " . $title . "\n" . "ツイート: " . $tweet . "\n\n";
      file_put_contents($file, $currentTweets);
    }

    // ツイート一覧を表示
    $file = "tweets.txt";
    if (file_exists($file)) {
      echo "<h2>ツイート一覧</h2>";
      $tweets = file_get_contents($file);
      $tweetArray = explode("\n\n", $tweets);

      foreach ($tweetArray as $tweet) {
        if (!empty($tweet)) {
          // タイトルとツイート内容を分割
          list($title, $content) = explode("\n", $tweet, 2);
          echo "<div class='tweet-container'>";
          // タイトルをリンクとして表示
          echo "<a href='tweet_detail.php?title=" . urlencode($title) . "'><strong>" . htmlspecialchars($title) . "</strong></a><br>";
          echo nl2br(htmlspecialchars($content));
          echo "</div>";
          echo "<hr>";  // 横線を追加
        }
      }
    } else {
      echo "<p>まだツイートはありません。</p>";
    }
    ?>

  </div>

</body>

</html>