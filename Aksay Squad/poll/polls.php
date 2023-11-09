<?php
$nameFile = 'poll-results.txt';
$current = 'pool-3';

$votes = array();

// pool-1
$key = 'pool-1';
$value = new stdClass();
$value->id = $key;
$value->question = 'lorem';
$value->answers = array('1','2','3','4');
$votes[$key]=$value;

// pool-2
$key = 'pool-2';
$value = new stdClass();
$value->id = $key;
$value->question = 'Мадик пернул?';
$value->answers = array('Да','Да','Да','Да','Фу кто пернул');
$votes[$key]=$value;

//pool-3
$key = 'pool-3';
$value = new stdClass();
$value->id = $key;
$value->question = 'Асхат крут?';
$value->answers = array('Да','Да','Да','Да','Да');
$votes[$key]=$value;


/* блок для вывода результатов если пользователь проголосовал */
if (isset($_COOKIE['polls'])) {
  $arrayPolls = explode(',',$_COOKIE['polls']);
  if (in_array($current, $arrayPolls)) {
    // получаем содержимое файла
    $output = file_get_contents(dirname(__FILE__).'/'.$nameFile);
    // декодируем содержимое в массив
    $output = json_decode($output, true);
    // проверяем есть если указанный ключ голосования в ассоциативном массиве
    if (array_key_exists($current, $output)) {
      // получаем значение, связанное с указанным ключом
      $votes[$current]->result = $output[$current];
    }
  }
}

echo json_encode($votes[$current]);

exit();