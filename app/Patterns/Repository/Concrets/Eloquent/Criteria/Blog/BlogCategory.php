<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria\Blog;

use App\Patterns\Repository\Criteria\CriterionInterface;


class BlogCategory implements CriterionInterface{

    public function apply($entity){
        return $entity->where('user_id', auth()->id());
    }
}

?>
