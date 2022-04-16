<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Tag;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\TagRepository;

class EloquentTagRepository extends Repository implements TagRepository {

    public function entity(){
        return Tag::class;
    }
}

?>
