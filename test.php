<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Test</title>
  <link rel="stylesheet" href="test.css">
  <link rel="shortcut icon" type="image/png" href="favicon.png"/>
</head>
<body>
<div class="content">
<?php

function loadData() {
  $dir = new DirectoryIterator('./questions');
  foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot() and $fileinfo->isFile()) {
      $fpath = './questions/' . $fileinfo->getFilename();
      $f = fopen($fpath, 'r');
      $content = fread($f,filesize($fpath));
      fclose($f);
      return $content;
    }
  }
  return null;
}

class Word {
  public function __construct(string $w, string $t,
    string $definition, $sentence) {
    $this->{'w'} = $w;
    $this->{'t'} = $t;
    $this->{'definition'} = $definition;
    $this->{'sentence'} = $sentence;
  }
}

function loadWords() {
  $words = array();
  $content = loadData();
  if ($content != null)  {
    $raw_data = explode("\n\n", $content);
    foreach ($raw_data as $entry) {
      if (strlen($entry) > 0) {
        $word_data = explode("\n", $entry);
        $w = new Word($word_data[0], $word_data[1], $word_data[2],
          sizeof($word_data) > 3 ? $word_data[3] : null);
        array_push($words, $w);
      }
    }
    return $words;
  }
}

class MultipleChoiceQuestion {
  public function __construct(Word $word, array $choice) {
    shuffle($choice);
    $index = rand(0, sizeof($choice));
    array_splice($choice, $index, 0, $word->definition);
    $this->{'choices'} = $choice;
    $this->{'word'} = $word;
    $this->{'answer'} = $index;
  }
}

function loadMultipleChoiceQuestions(array $words, int $num,
  int $num_choice) {
  $questions = array();
  $added = array();
  for ($i = 0; $i < $num; $i++) {
    $word_index = rand(0, sizeof($words) - 1);
    while (in_array($word_index, $added)) {
      $word_index = rand(0, sizeof($words) - 1);
    }

    $choices = array();
    for ($j = 0 ; $j < $num_choice - 1; $j++) {
      $choice_index = rand(0, sizeof($words) - 1);
      while ($choice_index == $word_index) {
        $choice_index = rand(0, sizeof($words) - 1);
      }
      array_push($choices, $words[$choice_index]->definition);
    }

    $q = new MultipleChoiceQuestion(
      $words[$word_index], $choices);
    array_push($questions, $q);
    array_push($added, $word_index);
  }
  return $questions;
}

function renderMultipleChoiceQuestions($questions) {
  echo '<h3 class="section-header">Multiple Choices</h3>';
  echo '<p class="description">Choose the correct definition</p>';
  echo '<div class="questions">';
  for ($i = 0; $i < sizeof($questions); $i++) {
    $q = $questions[$i];

    echo '<div class="question">';
    $w = $q->word->w;
    echo "<select id=\"$i\" name=\"$w\" class=\"choices\">";
    echo "<option value=\"-1\">None</option>";
    echo "<option value=\"0\">1</option>";
    echo "<option value=\"1\">2</option>";
    echo "<option value=\"2\">3</option>";
    echo "<option value=\"3\">4</option>";
    echo "</select>";

    $answer = $q->answer;
    echo "<span class=\"answer\">$answer</span>";

    echo '<div class="word">';
    $qi = $i + 1;
    echo "<span class=\"num\">$qi.</span>";

    $w = $q->word->w;
    echo "<span class=\"word\">$w</span>";
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
  if ($n > 0) {
    $words = loadWords();
    $mq = loadMultipleChoiceQuestions($words, $n, 4);
    renderMultipleChoiceQuestions($mq);
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
