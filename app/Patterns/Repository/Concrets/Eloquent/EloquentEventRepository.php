<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Event;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\EventRepository;

class EloquentEventRepository extends Repository implements EventRepository {

    public function entity(){
        return Event::class;
    }
}

?>
