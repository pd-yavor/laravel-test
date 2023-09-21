<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Repositories\BaseRepository;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new ProductCategory();
    }
}
