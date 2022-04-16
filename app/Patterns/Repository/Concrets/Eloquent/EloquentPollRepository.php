<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Poll;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\PollRepository;

class EloquentPollRepository extends Repository implements PollRepository {

    public function entity(){
        return Poll::class;
    }
}

?>
