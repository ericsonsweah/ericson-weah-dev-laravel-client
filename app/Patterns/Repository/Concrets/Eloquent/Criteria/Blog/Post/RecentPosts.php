<?php namespace App\Patterns\Repository\Concrets\Eloquent\Criteria\Blog\Post;

use App\Patterns\Repository\Criteria\CriterionInterface;


class RecentPosts implements CriterionInterface{

    public function apply($entity){
        return $entity->latest()->limit(1);
    }
}

?>
