<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Reply;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\ReplyRepository;

class EloquentReplyRepository extends Repository implements ReplyRepository {

    public function entity(){
        return Reply::class;
    }
}

?>
