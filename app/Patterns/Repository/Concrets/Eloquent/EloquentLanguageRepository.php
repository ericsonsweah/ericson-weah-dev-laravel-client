<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Language;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\LanguageRepository;

class EloquentLanguageRepository extends Repository implements LanguageRepository {

    public function entity(){
        return Language::class;
    }
}

?>
