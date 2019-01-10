(function() {
  document.getElementById('submit').addEventListener('click', function() {
    let questions = document.getElementsByClassName('question');
    let done = true;
    let correct = 0;
    for (let i = 0; i < questions.length; ++i) {
      let select = questions[i].getElementsByTagName('select')[0];
      let answer = questions[i].getElementsByClassName('answer')[0];
      select.classList.remove('error');

      if (parseInt(select.value) < 0) {
        done = false;
        break;
      } else if (select.value === answer.innerHTML) {
        correct += 1;
      } else {
        select.classList.add('error');
      }
    }

    document.getElementById('not-done').classList.add('hidden');
    if (done) {
      document.getElementById('correct').innerHTML =
        `Correct: ${correct}/${questions.length}`;
    } else {
      document.getElementById('not-done').classList.remove('hidden');
    }
  });
})();
