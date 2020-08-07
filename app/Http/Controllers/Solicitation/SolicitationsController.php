<?php

namespace App\Http\Controllers\Solicitation;

use App\Http\Controllers\Controller;
use App\Services\Solicitations\SolicitationsService;
use Illuminate\Http\Request;

class SolicitationsController extends Controller
{

    private $solicitationsService;

    public function __construct(SolicitationsService $solicitationsService)
    {
        $this->solicitationsService = $solicitationsService;
    }

    public function getAll()
    {
        return $this->solicitationsService->getAll();
    }

    public function getAllUser()
    {
        return $this->solicitationsService->getAllUser();
    }

    public function get($id)
    {
        return $this->solicitationsService->get($id);
    }

    public function store(Request $request)
    {
        return $this->solicitationsService->store($request);
    }

    public function update($id, Request $request)
    {
        return $this->solicitationsService->update($id, $request);
    }
}
