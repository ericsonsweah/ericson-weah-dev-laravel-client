<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria;

use App\Patterns\Repository\Criteria\CriterionInterface;


class Accepted implements CriterionInterface{

    public function apply($entity){
        return $entity->where('accepted', true);
    }
}

?>
