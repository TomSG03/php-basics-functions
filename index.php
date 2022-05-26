<?php

declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
  OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
  OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
  OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
  OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];

function listItem(array $list, string $title): void
{
  if (count($list)) {
    echo $title . PHP_EOL;
    echo implode("\n", $list) . "\n";
  } else {
    echo 'Список покупок пуст.' . PHP_EOL;
  }
}

function listOperation(array $items,array $operations): void
{
  if (count($items)) {
    echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
  } else {
    $arr = $operations;
    array_splice($arr, 2, 1);
    echo implode(PHP_EOL, $arr) . PHP_EOL . '> ';
  }
}

function choice(array $items, array $operations): int
{
  do {
    system('clear');
//    system('cls'); // windows

    listItem($items, 'Ваш список покупок: ');

    echo 'Выберите операцию для выполнения: ' . PHP_EOL;
    listOperation($items, $operations);
    $operationNumber = trim(fgets(STDIN));

    if (!array_key_exists($operationNumber, $operations)) {
      system('clear');

      echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
    }
  } while (!array_key_exists($operationNumber, $operations));

  return (int)$operationNumber;
}

function addItem(array &$items): void
{
  echo "Введение название товара для добавления в список: \n> ";
  $itemName = trim(fgets(STDIN));
  $items[] = $itemName;
}

function deleteItem(array &$items): void
{
  listItem($items, 'Текущий список покупок:');
  if (count($items)) {
    echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));

    if (in_array($itemName, $items, true) !== false) {
      while (($key = array_search($itemName, $items, true)) !== false) {
        unset($items[$key]);
      }
    } 
  } else {
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
  }
}

function printItem(array &$items): void
{
  echo 'Ваш список покупок: ' . PHP_EOL;
  echo implode(PHP_EOL, $items) . PHP_EOL;
  echo 'Всего ' . count($items) . ' позиций. ' . PHP_EOL;
  echo 'Нажмите enter для продолжения';
  fgets(STDIN);
}


do {
  $operationNumber = choice($items, $operations);
  echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;

  switch ($operationNumber) {
    case OPERATION_ADD:
      addItem($items);
      break;

    case OPERATION_DELETE:
      deleteItem($items);
      break;

    case OPERATION_PRINT:
      printItem($items);
      break;
  }

  echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;
