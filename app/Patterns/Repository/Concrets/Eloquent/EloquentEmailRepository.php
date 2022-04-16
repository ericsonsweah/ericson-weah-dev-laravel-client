<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Email;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\EmailRepository;

class EloquentEmailRepository extends Repository implements EmailRepository {

    public function entity(){
        return Email::class;
    }
}

?>
