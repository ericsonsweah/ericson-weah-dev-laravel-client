<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria\Auth;

use App\Patterns\Repository\Criteria\CriterionInterface;


class AuthUser implements CriterionInterface{

    public function apply($entity){
        return $entity->where('user_id', auth()->id());
    }
}

?>
