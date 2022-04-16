<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Detail;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\DetailRepository;

class EloquentDetailRepository extends Repository implements DetailRepository {

    public function entity(){
        return Detail::class;
    }
}

?>
