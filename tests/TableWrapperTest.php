<?php
declare(strict_types= 1);

require_once 'autoloader.php';
//require_once '../autoloader.php';
//require_once "../src/interfaces/TableWrapperInterface.php";
//require_once "../src/classes/TableWrapper.php";

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use classes\TableWrapper;

#[CoversClass(TableWrapper::class)]
class TableWrapperTest extends TestCase
{
    #[DataProvider('additionProvider')]
   public function testInsert(string $surname, string $name, int $age, array $dest_arr) {
        $users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);
        $params = ["surname" => $surname, "name" => $name, "age" => $age];
        $id = $users->insert($params);
        $source_arr = $users->get()[$id];
        $users->clear();
        $this->assertEquals($dest_arr, $source_arr);
    }

    public static function additionProvider() {
        return [
            "First row" => ["Сидоров", "Иван", 63, ["surname" => "Сидоров", "name" => "Иван", "age" => 63]],
            "Second row" => ["Воронов", "Владимир", 45 , ["surname" => "Воронов", "name" => "Владимир", "age" => 45]],
            "Third row" => ["Крутов", "Валентин", 30, ["surname" => "Крутов", "name" => "Валентин", "age" => 30]],
            "Fourth row" => ["Петров", "Игорь", 25, ["surname" => "Петров", "name" => "Игорь", "age" => 25]],
        ];
    }
    
}
