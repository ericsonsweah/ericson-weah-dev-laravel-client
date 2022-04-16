<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Feed;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\FeedRepository;

class EloquentFeedRepository extends Repository implements FeedRepository {

    public function entity(){
        return Feed::class;
    }
}

?>
