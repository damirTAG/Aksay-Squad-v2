<?php
// Если  запрос не AJAX (XMLHttpRequest), то завершить работу
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;}

if (empty($_POST['id'])) {exit();}

$nameFile = 'poll-results.txt';

$id = $_POST['id'];
$answer = $_POST['poll'];
$count = $_POST['count'];

if (isset($_COOKIE['polls'])) {
  $arrayPolls = explode(',',$_COOKIE['polls']);
  if (in_array($id, $arrayPolls)) {
    exit();
  }
}


// массив, который будем возвращать клиенту
$result = array();

// если файлами с результатами нет
if (!file_exists($nameFile)) {
  // результирующий массив
  $output = array();
  // массив для хранения ответов
  $answers = array();
  // заполняем массив нулями
  for ($i=0; $i<=$count-1; $i++) {
    $answers[$i] = 0;
  }
  // увеличиваем в массиве полученный элемент на 1
  $answers[$answer-1] = $answers[$answer-1] + 1;
  // связываем id опроса с ответами   
  $output[$id] = $answers;
  // кодируем ассоциативный массив в JSON
  $output = json_encode($output);
  // записываем в файл
  file_put_contents(dirname(__FILE__).'/'.$nameFile, $output, LOCK_EX);
} else {
  // получаем содержимое файла
  $output = file_get_contents(dirname(__FILE__).'/'.$nameFile);
  // декодируем содержимое в массив
  $output = json_decode($output, true);
  // проверяем есть если указанный ключ голосования в ассоциативном массиве
  if (array_key_exists($id, $output)) {
    // получаем значение, связанное с указанным ключом
    $answers = $output[$id];
    // увеличиваем в массиве полученный элемент на 1
    $answers[$answer-1] = $answers[$answer-1] + 1;
    // перезеписываем массив ответов, связанных с ключом
    $output[$id] = $answers;
  } else {
    /* если не найден переданный ключ в массиве */
    // массив для хранения ответов
    $answers = array();
    // заполняем массив нулями
    for ($i=0; $i<=$count-1; $i++) {
      $answers[$i] = 0;
    }
    // увеличиваем в массиве полученный элемент на 1
    $answers[$answer-1] = $answers[$answer-1] + 1;
    // добавляем в результирующий массив ключом и связанный с ним ассоциативный массив
    $output[$id] = $answers;
  }
  // кодируем ассоциативный массив в JSON
  $output = json_encode($output);
  // записываем в файл
  file_put_contents(dirname(__FILE__).'/'.$nameFile, $output, LOCK_EX);
}

if (isset($_COOKIE['polls'])) {
  $arrayPolls = explode(',',$_COOKIE['polls']);
} else {
  $arrayPolls = array();
}
array_push($arrayPolls,$id);
setcookie('polls', implode(',',$arrayPolls),time() + (86400 * 365),'/');   

$result[$id] = $answers;
$result = json_encode($result);  
echo $result;
exit();
?>