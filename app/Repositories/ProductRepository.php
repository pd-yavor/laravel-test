<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Product();
    }
}
