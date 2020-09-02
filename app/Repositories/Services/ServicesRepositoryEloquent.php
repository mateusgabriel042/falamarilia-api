<?php

namespace App\Repositories\Services;

use App\Models\Category;
use App\Models\Service;
use App\Repositories\Services\ServicesRepositoryInterface;
use Illuminate\Http\Request;

class ServicesRepositoryEloquent implements ServicesRepositoryInterface
{
    private $service;
    private $serviceValidate;

    public function __construct(Service $service)
    {
        $this->service = $service;
        $this->serviceValidate = auth()->user()->service;
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
        if ($this->serviceValidate == -1) {
            return $this->service->create($request->all());
        }
        return [];
    }

    public function storeCategory(Request $request)
    {
        if ($this->serviceValidate == -1) {
            return Category::create($request->all());
        }
        return [];
    }

    public function update(int $id, Request $request)
    {
        if ($this->serviceValidate == -1) {
            return $this->service
                ->where('id', $id)
                ->update($request->all());
        }
        return [];
    }

    public function updateCategory(int $id, int $category_id, Request $request)
    {
        if ($this->serviceValidate == -1) {
            return Category::where('id', $category_id)
                ->where('service_id', $id)
                ->update($request->all());
        }
        return [];
    }

    public function destroy(int $id)
    {
        if ($this->serviceValidate == -1) {
            $service = $this->service->find($id);
            $service->category()->delete();
            return $service->delete();
        }
        return [];
    }

    public function destroyCategory(int $id, int $category_id)
    {
        if ($this->serviceValidate == -1) {
            $category = Category::where('id', $category_id)
                ->where('service_id', $id)
                ->first();
            return $category->delete();
        }
        return [];
    }
}
