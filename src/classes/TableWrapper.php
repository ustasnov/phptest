<?php

namespace classes;

use interfaces\TableWrapperInterface;

class TableWrapper implements TableWrapperInterface
{
    private array $columns = [];
    //[
    //  "surname" => "string",
    //  "name" => "string",
    //  "age" => "int"
    //];

    private array $rows = [];

    public function __construct(array $columns) {
      $this->columns = $columns;
    }

    public function validate(array $values): void {
      //проверяем переданное значение
      if (!is_array($values)) {
        throw new \Exception("Переданное значение не массив!");
      }

      // проверяем колонки
      $columns_count = count($this->columns);
      if (count($values) !== $columns_count) {
        throw new \Exception("Массив значений колонок должен состоять из $columns_count элементов!");
      }

      foreach($this->columns as $col_key => $col_type) {
        if (!array_key_exists($col_key, $values)) {
          throw new \Exception("В переданных данных отсутствует значение колонки $col_key!");
        }
        if ($col_type === "int" and !is_int($values[$col_key])) {
          throw new \Exception("Тип значения колонки $col_key не целое число!");
        } 
        if ($col_type === "string" and !is_string($values[$col_key])) {
          throw new \Exception("Тип значения колонки $col_key не строка!");
        }
      }
    }

    public function insert(array $values): void
    {
        $this->validate($values);
        $this->rows[] = $values;     
    }

    public function update(int $id, array $values): array
    {
      $this->validate($values);
      if (!array_key_exists($id, $this->rows)) {
        throw new \Exception("В таблице не записи с id = $id!");  
      } 
      $this->rows[$id] = $values;
      return $this->rows[$id];    
    }

    public function delete(int $id): void
    {
      if (!array_key_exists($id, $this->rows)) {
        throw new \Exception("В таблице не записи с id = $id!");  
      }
      unset($rows[$id]);
    }

    public function get(): array {
      return $this->rows;
    }
}
