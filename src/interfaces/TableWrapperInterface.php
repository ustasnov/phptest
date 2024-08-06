<?php

namespace interfaces;

interface TableWrapperInterface
{
    public function insert(array $values): int;
    public function update(int $id, array $values): array;
    public function delete(int $id): void;
    public function get(): array;
}
