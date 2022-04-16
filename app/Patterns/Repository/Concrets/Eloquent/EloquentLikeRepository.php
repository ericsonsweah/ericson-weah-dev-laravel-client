<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Like;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\LikeRepository;

class EloquentLikeRepository extends Repository implements LikeRepository {

    public function entity(){
        return Like::class;
    }
}

?>
