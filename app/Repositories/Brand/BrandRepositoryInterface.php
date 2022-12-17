<?php

namespace App\Repositories\Brand;

use App\Repositories\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{

    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(array $data,$id);
    public function delete($id);
}
