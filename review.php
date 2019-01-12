<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review</title>
  <link rel="stylesheet" href="global.css">
  <link rel="stylesheet" href="review.css">
  <link rel="shortcut icon" type="image/png" href="favicon.png"/>
</head>
<body>
  <div class="content">
    <div class="top">
      <div class="content">
        <h3 class="header">Review</h3>

        <div class="file">
          <span>Select the Word Collection: </span>
          <select id="collection">
            <?php
            require 'include/loader.php';

            $files = getAllFiles();
            for ($i = 0; $i < sizeof($files); $i++) {
              echo "<option value=\"$i\">";
              echo $files[$i];
              echo '</option>';
            }
            ?>
          </select>

          <span class="return">
            <a href="index.php" class="back">Back</a>
          </span>
        </div>
      </div>
    </div>

    <div class="word-list">
      <?php
      for ($i = 0; $i < sizeof($files); $i++) {
        $fp = $files[$i];
        $content = loadFile('./questions/' . $fp);
        $words = loadWords($content);

        foreach ($words as $word) {
          echo "<div class=\"word list-$i hidden\">";
          echo '<div class="word-body">';
          echo '<div class="word-text"><b>';
          echo $word->w;
          echo '</b></div>';

          echo '<span class="word-type"><i>';
          echo $word->t;
          echo '</i></span>';

          echo '<span class="word-definition">';
          echo $word->definition;
          echo '</span>';

          if ($word->sentence != null) {
            echo '<div class="word-sentence">';
            echo $word->sentence;
            echo '</div>';
          }

          echo '</div>';
          echo '</div>';
        }
      }
      ?>
    </div>
  </div>
  <script src="review.js"></script>
</body>
</html>
