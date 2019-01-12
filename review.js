(function() {
  function show(n) {
    let words = document.getElementsByClassName('word');
    for (let i = 0; i < words.length; ++i) {
      words[i].classList.add('hidden');
    }

    words = document.getElementsByClassName('list-' + n);
    for (let i = 0; i < words.length; ++i) {
      words[i].classList.remove('hidden');
    }
  }

  show(0);

  let select = document.getElementById('collection');
  select.addEventListener('change', function() {
    show(select.value);
  });
})();
