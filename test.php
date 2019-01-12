<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Test</title>
  <link rel="stylesheet" href="global.css">
  <link rel="stylesheet" href="test.css">
  <link rel="shortcut icon" type="image/png" href="favicon.png"/>
</head>
<body>
<div class="content">
<?php

require 'include/loader.php';

function renderQuestions($questions) {
  echo '<h3 class="section-header">Multiple Choices</h3>';
  echo '<p class="description">Choose the correct definition</p>';
  echo '<div class="questions">';
  for ($i = 0; $i < sizeof($questions); $i++) {
    $q = $questions[$i];

    echo '<div class="question-item">';
    $w = $q->question;
    echo "<select id=\"$i\" name=\"$w\" class=\"choices\">";
    echo "<option value=\"-1\">None</option>";
    echo "<option value=\"0\">1</option>";
    echo "<option value=\"1\">2</option>";
    echo "<option value=\"2\">3</option>";
    echo "<option value=\"3\">4</option>";
    echo "</select>";

    $answer = $q->answer;
    echo "<span class=\"answer\">$answer</span>";

    echo '<div class="question">';
    $qi = $i + 1;
    echo "<span class=\"num\">$qi.</span>";

    $w = $q->question;
    echo "<span class=\"question\">$w</span>";
    echo '</div>';

    for ($j = 0; $j < sizeof($q->choices); $j++) {
      echo '<div class="options">';
      $num = $j + 1;
      echo "<span class=\"num\">($num)</span>";
      $c = $q->choices[$j];
      echo "<span>$c</span>";
      echo '</div>';
    }
    echo '</div>';
  }
  echo '</div>';
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  header('Location: index.php');
  exit();
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $n = (int)$_POST['num-questions'];
  $collection = $_POST['collection'];
  $num_choice = 4;
  if ($n > 0 && $collection != '') {
    $content = loadFile('./questions/' . $collection);
    $words = loadWords($content);
    if (sizeof($words) > $num_choice) {
      $questions = null;
      if ($_POST['test-type'] == 'sentence') {
        $questions = loadSentenceQuestions($words, $n, $num_choice);
      } else if ($_POST['test-type'] == 'definition') {
        $questions = loadDefinitionQuestions($words, $n, $num_choice);
      }
      if ($questions != null) {
        renderQuestions($questions);
      }
    } else {
      echo '<h4>Not enough Data for composing the test</h4>';
    }
  } else {
    echo '<h4>Data not collected</h4>';
  }
}

?>

  <div class="result">
    <button id="submit">Submit</button>
    <div id="correct" class="correct"></div>
    <div id="not-done" class="hidden">Questions are not all done</div>
  </div>

  <div class="back">
    <a href="index.php">Back</a>
  </div>

</div>
<script src="test.js"></script>
</body>
</html>
