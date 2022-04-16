<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Country;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\CountryRepository;

class EloquentCountryRepository extends Repository implements CountryRepository {

    public function entity(){
        return Country::class;
    }
}

?>
