<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Chat;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\ChatRepository;

class EloquentChatRepository extends Repository implements ChatRepository {

    public function entity(){
        return Chat::class;
    }
}

?>
