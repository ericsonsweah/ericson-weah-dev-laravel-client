<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Category;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\CategoryRepository;

class EloquentCategoryRepository extends Repository implements CategoryRepository {

    public function entity(){
        return Category::class;
    }
}

?>
