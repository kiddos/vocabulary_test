<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vocabulary Tests</title>
  <link rel="stylesheet" href="global.css">
  <link rel="stylesheet" href="index.css">
  <link rel="shortcut icon" type="image/png" href="favicon.png"/>
</head>
<body>
  <div class="content">
    <h1 class="header">Vocabulary Tests</h1>

    <form action="test.php" method="POST" class="form">
      <div class="option">
        <span>Choose Test Type:</span>
        <select id="test-type" name="test-type">
          <option value="definition">Find Definition</option>
          <option value="sentence">Fit Sentence</option>
        </select>
      </div>

      <div class="option">
        <span>Choose Collection: </span>
        <select name="collection" id="collection">
          <?php
          require 'include/loader.php';

          $files = getAllFiles();
          foreach($files as $fp) {
            echo "<option value=\"$fp\">";
            echo $fp;
            echo '</option>';
          }
          ?>
        </select>
      </div>

      <div class="option">
        <span>Number of Questions: </span>
        <input id="num-questions" name="num-questions" type="number" value="10">
      </div>
      <input type="submit" value="Start" class="button">

      <a href="review.php" class="button">Review</a>
      <a href="add_word.php" class="button">Add New Words</a>
    </form>
  </div>
</body>
</html>
