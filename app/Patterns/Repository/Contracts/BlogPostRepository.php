<?php namespace App\Patterns\Repository\Contracts;

interface BlogPostRepository {
    public function findBySlug($slug);
}

?>
