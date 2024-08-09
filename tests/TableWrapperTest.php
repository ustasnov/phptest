<?php
declare(strict_types= 1);

require_once 'autoloader.php';

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use classes\TableWrapper;

#[CoversClass(TableWrapper::class)]
class TableWrapperTest extends TestCase
{
    #[DataProvider('commonDataProvider')]
    public function testInsert(string $surname, string $name, int $age, array $dest_arr) {
        $users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);
        $id = $users->insert(["surname" => $surname, "name" => $name, "age" => $age]);
        $source_arr = $users->get()[$id];
        $users->clear();
        $this->assertEquals($dest_arr, $source_arr);
    }

    public function testUpdate() {
        $users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);
        $id = $users->insert(["surname" => "Сидоров", "name" => "Иван", "age" => 63]);
        $dest_arr = ["surname" => "Сидоренко", "name" => "Илья", "age" => 60];
        $users->update($id, $dest_arr);
        $source_arr = $users->get()[$id];  
        $this->assertEquals($dest_arr, $source_arr);
    }

    public function testDelete() {
        $users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);
        $id = $users->insert(["surname" => "Сидоров", "name" => "Иван", "age" => 63]);
        $users->delete($id);
        $this->assertEquals(0, count($users->get()));
    }

    public function testGet() {
        $users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);
        $id = $users->insert(["surname" => "Сидоров", "name" => "Иван", "age" => 63]);
        $this->assertEquals(1, count($users->get()));
    }

    #[DataProvider('exceptionDataProvider')]
    public function testValidateExceptions(array $testArray, string $message) {
        $users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);
        $this->expectExceptionMessage($message);
        $users->validate($testArray);
    }

    public function testUpdateException() {
        $users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);
        $id = $users->insert(["surname" => "Сидоров", "name" => "Иван", "age" => 63]);
        $this->expectExceptionMessage("В таблице нет записи с id = 2!");
        $users->update(2, ["surname" => "Сидоренко", "name" => "Илья", "age" => 60]);
    }

    public function testDeleteException() {
        $users = new TableWrapper(["surname" => "string", "name" => "string", "age" => "int"]);
        $id = $users->insert(["surname" => "Сидоров", "name" => "Иван", "age" => 63]);
        $this->expectExceptionMessage("В таблице нет записи с id = 2!");
        $users->delete(2);
    }

    public static function commonDataProvider() {
        return [
            "First row" => ["Сидоров", "Иван", 63, ["surname" => "Сидоров", "name" => "Иван", "age" => 63]],
            "Second row" => ["Воронов", "Владимир", 45 , ["surname" => "Воронов", "name" => "Владимир", "age" => 45]],
            "Third row" => ["Крутов", "Валентин", 30, ["surname" => "Крутов", "name" => "Валентин", "age" => 30]],
            "Fourth row" => ["Петров", "Игорь", 25, ["surname" => "Петров", "name" => "Игорь", "age" => 25]]
        ];
    }

    public static function exceptionDataProvider() {
        return [
            [["surname" => "Сидоров", "name" => "Иван"], "Массив значений колонок должен состоять из 3 элементов!"],
            [["surname" => "Сидоров", "name" => "Иван", "a" => 30], "В переданных данных отсутствует значение колонки age!"],
            [["surname" => "Воронов", "name" => "Владимир", "age" => "45"], "Тип значения колонки age не целое число!"],
            [["surname" => 22, "name" => "Валентин", "age" => 30], "Тип значения колонки surname не строка!"]
        ];
    }  
}
