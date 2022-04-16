<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Meetup;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\MeetupRepository;

class EloquentMeetupRepository extends Repository implements MeetupRepository {

    public function entity(){
        return Meetup::class;
    }
}

?>
