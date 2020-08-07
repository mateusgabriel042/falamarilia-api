<?php

namespace App\Repositories\Services;

use App\Models\Category;
use App\Models\Service;
use App\Repositories\Services\ServicesRepositoryInterface;
use Illuminate\Http\Request;

class ServicesRepositoryEloquent implements ServicesRepositoryInterface
{
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function getAll()
    {
        return $this->service
            ->with('category')
            ->get();
    }

    public function get(int $id)
    {
        return $this->service
            ->where('id', $id)
            ->with('category')
            ->get();
    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function storeCategory(Request $request)
    {
        return Category::create($request->all());
    }

    public function update(int $id, Request $request)
    {
        return $this->service
            ->where('id', $id)
            ->update($request->all());
    }

    public function updateCategory(int $id, int $category_id, Request $request)
    {
        return Category::where('id', $category_id)
            ->where('service_id', $id)
            ->update($request->all());
    }

    public function destroy(int $id)
    {
        $service = $this->service->find($id);
        $service->category()->delete();
        return $service->delete();
    }

    public function destroyCategory(int $id, int $category_id)
    {
        // dd($category_id);
        $category = Category::where('id', $category_id)
            ->where('service_id', $id)
            ->first();
        return $category->delete();
    }
}
