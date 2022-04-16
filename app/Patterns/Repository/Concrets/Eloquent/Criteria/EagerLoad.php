<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria;

use App\Patterns\Repository\Criteria\CriterionInterface;


class EagerLoad implements CriterionInterface{

    protected $relations;

    public function __construct(array $relations){
        $this->relations = $relations;
    }
    
    public function apply($entity){
        return $entity->with($this->relations);
    }
}

?>
