<?php

require 'include/loader.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['word']) && isset($_POST['type']) &&
      isset($_POST['definition']) && isset($_POST['sentence'])) {
    $word = $_POST['word'];
    $type = $_POST['type'];
    $definition = $_POST['definition'];
    $sentence = $_POST['sentence'];

    $filepath = './questions/my_words.txt';
    $content = loadFile($filepath);
    $words = loadWords($content);

    if (!containsWord($word, $words)) {
      $w = new Word($word, $type, $definition, $sentence);
      array_push($words, $w);
      writeData($words, $filepath);
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Word</title>
  <link rel="shortcut icon" type="image/png" href="favicon.png"/>
  <link rel="stylesheet" href="global.css">
  <link rel="stylesheet" href="add_word.css">
</head>
<body>
  <div class="content">
    <h2 class="header">Add a New Word to Dictionary</h2>

    <form action="add_word.php" method="POST">
      <input type="text" name="word" id="word" placeholder="Word" autocomplete="off" size="60">
      <input type="text" name="type" id="type" placeholder="Type (eg. noun, adjective, adverb, verb)" autocomplete="off" size="60">
      <input type="text" name="definition" id="definition" placeholder="Definition" autocomplete="off">
      <textarea id="sentence" name="sentence" placeholder="Place the word in a sentence" cols="60" rows="6"></textarea>

      <div class="button-panel">
        <input type="submit" value="Add" class="button">
      </div>
    </form>

    <div class="back">
      <a href="index.php">Back</a>
    </div>
  </div>
</body>
</html>
