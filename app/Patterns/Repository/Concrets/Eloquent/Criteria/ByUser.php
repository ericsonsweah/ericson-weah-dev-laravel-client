<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria;

use App\Patterns\Repository\Criteria\CriterionInterface;


class ByUser implements CriterionInterface{

    protected $userId;

    public function __construct($userId){
        $this->userId = $userId;
    }
    public function apply($entity){
        return $entity->where('user_id', $this->userId);
    }
}

?>
