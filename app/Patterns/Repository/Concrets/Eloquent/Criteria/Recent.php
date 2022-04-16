<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria;

use App\Patterns\Repository\Criteria\CriterionInterface;


class Recent implements CriterionInterface{

    protected $limit;

    public function __construct(int $limit = 5)
    {
        $this->limit = $limit;
    }
    public function apply($entity){
        return $entity->latest()->take($this->limit);
    }
}

?>
