<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Friend;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\FriendRepository;

class EloquentFriendRepository extends Repository implements FriendRepository {


    public function entity(){
        return Friend::class;
    }

}

?>
