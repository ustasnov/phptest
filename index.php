<?php

require_once 'autoloader.php';
//require_once 'PHPUnit\Framework.php';

use classes\TableWrapper;

$users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);

$users->insert(["surname" => "Сидоров", "name" => "Иван", "age" => 63]);
$users->insert(["surname" => "Воронов", "name" => "Владимир", "age" => 45]);
$users->insert(["surname" => "Крутов", "name" => "Валентин", "age" => 30]);
$users->insert(["surname" => "Петров", "name" => "Игорь", "age" => 25]);

$users_list = $users->get();

foreach($users_list as $user) {
  echo $user["name"] . ' ' .  $user["surname"] . PHP_EOL;
}



echo PHP_EOL;