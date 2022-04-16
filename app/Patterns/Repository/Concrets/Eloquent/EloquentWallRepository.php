<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Wall;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\WallRepository;

class EloquentWallRepository extends Repository implements WallRepository {

    public function entity(){
        return Wall::class;
    }
}

?>
