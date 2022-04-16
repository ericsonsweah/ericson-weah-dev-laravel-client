<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Project;
use App\Patterns\Repository\Contracts\ProjectRepository;
use App\Patterns\Repository\Repository;

class EloquentProjectRepository extends Repository implements ProjectRepository{

    public function entity(){
        return Project::class;
    }
}

?>
