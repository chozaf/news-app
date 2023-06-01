<?php

namespace App\Http\Repositories;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function list();

    function findById(string $id): Model|null;

    function create(array $attributes): Model|null;

    function update(string $id, array $attributes): Model|null;

    function deleteById(string $id): Bool;
}
