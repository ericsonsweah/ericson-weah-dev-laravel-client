<?php  namespace App\Patterns\Repository\Criteria;


interface CriteriaInterface {
    public function withCriteria(...$criteria);
}
