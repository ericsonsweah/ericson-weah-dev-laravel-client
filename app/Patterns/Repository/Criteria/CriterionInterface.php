<?php  namespace App\Patterns\Repository\Criteria;


interface CriterionInterface {
    public function apply($entity);
}
