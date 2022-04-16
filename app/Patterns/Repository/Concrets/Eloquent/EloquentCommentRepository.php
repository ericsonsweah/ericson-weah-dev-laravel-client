<?php namespace App\Patterns\Repository\Concrets\Eloquent;

use App\Models\Comment;
use App\Patterns\Repository\Repository;
use App\Patterns\Repository\Contracts\CommentRepository;

class EloquentCommentRepository extends Repository implements CommentRepository {

    public function entity(){
        return Comment::class;
    }
}

?>
