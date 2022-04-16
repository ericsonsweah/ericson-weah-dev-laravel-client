<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\ContactMe;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\ContactMeRepository;

class EloquentContactMeRepository extends Repository implements ContactMeRepository {

    public function entity(){
        return ConactMe::class;
    }
}

?>
