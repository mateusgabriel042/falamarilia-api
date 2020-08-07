<?php

namespace App\Repositories\Services;

use Illuminate\Http\Request;

interface ServicesRepositoryInterface
{
    public function getAll();
    public function get(int $id);
    public function store(Request $request);
    public function update(int $id, Request $request);
    public function destroy(int $id);
    public function storeCategory(Request $request);
    public function updateCategory(int $id, int $category_id, Request $request);
    public function destroyCategory(int $id, int $category_id);
}
