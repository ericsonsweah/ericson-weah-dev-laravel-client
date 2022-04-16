<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Team;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\TeamRepository;

class EloquentTeamRepository extends Repository implements TeamRepository {

    public function entity(){
        return Team::class;
    }
}

?>
