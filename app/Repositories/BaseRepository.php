<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

class BaseRepository
{
    protected $model;

    public function getById(?int $id)
    {
        return $this->model->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }
}
