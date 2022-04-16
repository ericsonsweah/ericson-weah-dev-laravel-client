<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria;

use App\Patterns\Repository\Criteria\CriterionInterface;


class IsSuperAdmin implements CriterionInterface{

    public function apply($entity){
        return $entity->superAdmin();
    }
}

?>
