<?php

namespace App\Repositories\Blog;
use App\Repositories\RepositoryInterface;


interface BlogRepositoryInterface extends RepositoryInterface
{
    public function getLastestBlogs($limit = 3);
}
