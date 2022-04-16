<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Group;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\GroupRepository;

class EloquentGroupRepository extends Repository implements GroupRepository {

    public function entity(){
        return Group::class;
    }
}

?>
