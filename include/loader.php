<?php

function loadFile(string $fpath) {
  $content = '';
  if (file_exists($fpath)) {
    $f = fopen($fpath, 'r');
    $content = fread($f, filesize($fpath));
    fclose($f);
  }
  return $content;
}

function loadData() {
  $dir = new DirectoryIterator('./questions');
  foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot() && $fileinfo->isFile()) {
      $fpath = './questions/' . $fileinfo->getFilename();
      $f = fopen($fpath, 'r');
      $content = fread($f, filesize($fpath));
      fclose($f);
      return $content;
    }
  }
  return null;
}

function getAllFiles() {
  $files = array();
  $dir = new DirectoryIterator('./questions');
  foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot() && $fileinfo->isFile()) {
      array_push($files, $fileinfo->getFilename());
    }
  }
  return $files;
}

function writeData(array $words, string $path) {
  $f = fopen($path, 'w');
  if ($f) {
    for ($i = 0; $i < sizeof($words); $i++) {
      fwrite($f, $words[$i]->w . "\n");
      fwrite($f, $words[$i]->t . "\n");
      fwrite($f, $words[$i]->definition . "\n");
      fwrite($f, $words[$i]->sentence . "\n");
      fwrite($f, "\n");
    }
    fclose($f);
  }
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

function loadWords(string $content) {
  $words = array();
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
  }
  return $words;
}

function containsWord(string $word, array $words) {
  for ($i = 0; $i < sizeof($words); $i++) {
    if ($words[$i]->w == word) {
      return true;
    }
  }
  return false;
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
  for ($i = 0; $i < min($num, sizeof($words)); $i++) {
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

?>
