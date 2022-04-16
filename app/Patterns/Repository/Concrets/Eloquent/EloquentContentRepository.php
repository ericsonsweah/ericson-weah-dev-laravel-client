<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Content;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\ContentRepository;

class EloquentContentRepository extends Repository implements ContentRepository {

    public function entity(){
        return Content::class;
    }
}

?>
