<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Services\Services\ServicesService;
use Illuminate\Http\Request;

class ServicesController extends Controller
{

    private $servicesService;

    public function __construct(ServicesService $servicesService)
    {
        $this->servicesService = $servicesService;
    }

    public function getAll()
    {
        return $this->servicesService->getAll();
    }

    public function get($id)
    {
        return $this->servicesService->get($id);
    }

    public function store(Request $request)
    {
        return $this->servicesService->store($request);
    }

    public function storeCategory(Request $request)
    {
        return $this->servicesService->storeCategory($request);
    }

    public function update($id, Request $request)
    {
        return $this->servicesService->update($id, $request);
    }

    public function updateCategory($id, $category_id, Request $request)
    {
        return $this->servicesService->updateCategory($id, $category_id, $request);
    }

    public function destroy($id)
    {
        return $this->servicesService->destroy($id);
    }

    public function destroyCategory($id, $category_id)
    {
        return $this->servicesService->destroyCategory($id, $category_id);
    }
}
