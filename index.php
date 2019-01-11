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
      <div class="collection">
        <span>Choose Collection: </span>
        <select class="item" name="collection" id="collection">
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
      <div class="questions">
        <span>Number of Questions: </span>
        <input id="num-questions" name="num-questions" type="number" value="10">
      </div>
      <input type="submit" value="Start">
      <a href="add_word.php" class="add-word">Add Words</a>
    </form>
  </div>
</body>
</html>
