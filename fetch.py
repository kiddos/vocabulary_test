# -*- coding: utf-8 -*-

import requests
import os
import re

from bs4 import BeautifulSoup


URL = 'https://gre.economist.com/gre-advice/gre-vocabulary/which-words-study/most-common-gre-vocabulary-list-organized-difficulty'
r = requests.get(URL)
soup = BeautifulSoup(r.text)

if not os.path.isdir('questions'):
  os.mkdir('questions')


with open(os.path.join('questions', 'question-set-01.txt'), 'w') as f:
  for item in soup.select('.article-body p'):
    text = item.get_text(strip=True)
    word_pattern = re.compile(r'^(\w+): ')
    word = re.findall(r'^(\w+): ', text)
    if len(word) > 0:
      processed = text.replace(u'“', '"')
      word = word[0]
      word_type = re.findall(r': (\w+),', text)[0]
      definition = re.findall(r', (.+?)"', processed)[0]
      processed = text.replace(u'“', '<start-token>').replace(u'”', '<end-token>')
      sentence = re.findall(r'<start-token>(.+?)<end-token>', processed)
      definition = definition.split('Synonyms:')[0]
      print(word)
      print(word_type)
      print(definition)

      f.write(word + '\n')
      f.write(word_type + '\n')
      f.write(definition.encode('utf-8') + '\n')

      #  print(text)
      if len(sentence) > 0:
        print(sentence[0])
        f.write(sentence[0].encode('utf-8') + '\n')
      f.write('\n')
