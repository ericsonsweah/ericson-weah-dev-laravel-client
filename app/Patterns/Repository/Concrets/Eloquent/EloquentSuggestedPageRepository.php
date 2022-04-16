<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\SuggestedPage;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\SuggestedPageRepository;

class EloquentSuggestedPageRepository extends Repository implements SuggestedPageRepository {

    public function entity(){
        return SuggestedPage::class;
    }
}

?>
