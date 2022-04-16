<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Post;

use App\Patterns\Repository\Contracts\BlogPostRepository;
use App\Patterns\Repository\Repository;

class EloquentBlogPostRepository extends Repository implements BlogPostRepository{

    public function entity(){
        return Post::class;
    }
    public function findBySlug($slug){
        return $this->findWhereFirst('slug', $slug);
    }

}

?>
