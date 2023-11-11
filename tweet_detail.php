<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ツイート詳細</title>
</head>

<body>

  <div class="container">
    <h1>ツイート詳細</h1>

    <?php
    // タイトルがクエリパラメータとして送信された場合に表示
    if (isset($_GET['title'])) {
      $title = htmlspecialchars($_GET['title']);

      // タイトルに基づいてツイート内容を取得
      $file = "tweets.txt";
      $tweets = file_get_contents($file);
      $tweetArray = explode("\n\n", $tweets);

      foreach ($tweetArray as $tweet) {
        // タイトルと一致するツイートを探す
        $tweetParts = explode("\n", $tweet);
        if (count($tweetParts) >= 2) {
          list($tweetTitle, $content) = array_map('trim', explode("\n", $tweet, 2));

          // タイトルが一致した場合に表示
          if ($tweetTitle == "タイトル: " . $title) {
            echo "<h2>" . $title . "</h2>";
            echo nl2br(htmlspecialchars($content));
            break;
          }
        }
      }
    } else {
      // クエリパラメータがない場合はエラーメッセージを表示
      echo "<p>ツイートが見つかりません。</p>";
    }
    ?>

    <p><a href="index.php">戻る</a></p>
  </div>

</body>

</html>