<?php

namespace App\Http\Controllers\Notice;

use App\Http\Controllers\Controller;
use App\Services\Notices\NoticesService;
use Illuminate\Http\Request;

class NoticesController extends Controller
{

    private $noticesService;

    public function __construct(NoticesService $noticesService)
    {
        $this->noticesService = $noticesService;
    }

    public function getAll()
    {
        return $this->noticesService->getAll();
    }

    public function get($id)
    {
        return $this->noticesService->get($id);
    }

    public function store(Request $request)
    {
        return $this->noticesService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->noticesService->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->noticesService->destroy($id);
    }
}
