<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Profiles\ProfilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{

    private $profilesService;

    private $loggedUser;

    public function __construct(ProfilesService $profilesService)
    {
        $this->profilesService = $profilesService;
        $this->loggedUser = auth()->user()->id;
    }

    public function get(): JsonResponse
    {
        return $this->profilesService->get($this->loggedUser);
    }

    public function update(Request $request): JsonResponse
    {
        return $this->profilesService->update($this->loggedUser, $request);
    }
}
