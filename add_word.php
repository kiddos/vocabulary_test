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
    <h4 class="header">Add a Word to Dictionary</h4>
    <form action="add_word.php" method="POST">
      <input type="text" name="word" id="word" placeholder="Word" autocomplete="off">
      <input type="text" name="type" id="type" placeholder="Type (eg. noun, adjective, adverb, verb)" autocomplete="off">
      <input type="text" name="definition" id="definition" placeholder="Definition" autocomplete="off">
      <input type="text" name="sentence" id="sentence" placeholder="Place the word in a sentence" autocomplete="off">

      <div class="button">
        <input type="submit" value="Add">
      </div>
    </form>
  </div>
</body>
</html>
