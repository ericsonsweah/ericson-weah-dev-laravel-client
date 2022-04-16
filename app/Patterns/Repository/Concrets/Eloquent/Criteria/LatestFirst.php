<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria;

use App\Patterns\Repository\Criteria\CriterionInterface;


class LatestFirst implements CriterionInterface{

    public function apply($entity){
        return $entity->latest();
    }
}

?>
