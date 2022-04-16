<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria;

use App\Patterns\Repository\Criteria\CriterionInterface;


class IsAdmin implements CriterionInterface{

    public function apply($entity){
        return $entity->admin();
    }
}

?>
