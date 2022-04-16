<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Suggestion;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\SuggestionRepository;

class EloquentSuggestionRepository extends Repository implements SuggestionRepository {

    public function entity(){
        return Suggestion::class;
    }
}

?>
