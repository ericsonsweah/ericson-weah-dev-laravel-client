<?php namespace App\Patterns\Repository;

use Illuminate\Support\Arr;
use App\Patterns\Repository\Criteria\CriteriaInterface;
use App\Patterns\Repository\Exceptions\NoEntityDefined;
use App\Patterns\Repository\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface, CriteriaInterface {

    protected $entity;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();

    }
    public function all($lazy = false){
        
        if($lazy) return $this->entity->lazy();
        return $this->entity->get();

    }

    public function find($id)
    {
        return $this->entity->find($id);
    }
    public function findById($id)
    {
        return $this->entity->find($id);
    }
    public function findWhere($column, $value){
        return $this->entity->where($column, $value)->lazy();
    }

    public function findWhereFirst($column, $value){
        return $this->entity->where($column, $value)->first();
    }
    public function paginate($perPage = 10){
        return $this->entity->paginate($perPage);
    }
    public function create(array $properties){
        return $this->entity->create($properties);
    }

    public function update(int $id, array $properties){
        return $this->findById($id)->update($properties);
    }

    public function delete(int $id){
        $this->find($id)->delete();
    }

    public function deleteById(int $id){
        $this->findById($id)->delete();
    }

    protected function resolveEntity(){

        if(!method_exists($this,  'entity')) throw new NoEntityDefined('No entity defined');

        return app()->make($this->entity());

    }
    public function withCriteria(...$criteria){
        $criteria = Arr::flatten($criteria);
        foreach($criteria as $criterion){
            $this->entity = $criterion->apply($this->entity);
        }
        return $this;
    }
}

?>
