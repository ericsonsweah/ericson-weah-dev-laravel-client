<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\User;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\UserRepository;

class EloquentUserRepository extends Repository implements UserRepository {

    public function entity(){
        return User::class;
    }

    // public function admins(){
    //     return $this->entity->where('is_admin', 1)->lazy();
    // }
}

?>
