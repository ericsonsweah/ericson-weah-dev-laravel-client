<?php namespace App\Patterns\Repository\Contracts;

interface RepositoryInterface{
    public function all();
    public function find(int $id);
    public function findById(int $id);
    public function findWhere($column, $value);
    public function findWhereFirst($column, $value);
    public function paginate(int $perPage = 10);
    public function create(array $properties);
    public function update(int $id, array $properties);
    public function delete(int $id);
    public function deleteById(int $id);
}

?>
