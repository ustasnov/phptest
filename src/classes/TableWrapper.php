<?php

namespace classes;

use interfaces\TableWrapperInterface;

class TableWrapper implements TableWrapperInterface
{
    private array $columns = [];
    private array $rows = [];

    public function __construct(array $columns) {
      $this->columns = $columns;
    }

    public function validate(array $values): void {
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

    public function insert(array $values): int
    {
        $this->validate($values);
        $this->rows[] = $values;
        end($this->rows);
        return key($this->rows);     
    }

    public function update(int $id, array $values): array
    {
      $this->validate($values);
      if (!array_key_exists($id, $this->rows)) {
        throw new \Exception("В таблице нет записи с id = $id!");  
      } 
      $this->rows[$id] = $values;
      return $this->rows[$id];    
    }

    public function delete(int $id): void
    {
      if (!array_key_exists($id, $this->rows)) {
        throw new \Exception("В таблице нет записи с id = $id!");  
      }
      unset($this->rows[$id]);
    }

    public function clear(): void {
      $this->rows = [];
    }

    public function get(): array {
      return $this->rows;
    }
}
