<?php

namespace App\Repositories\Profiles;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ProfilesRepositoryInterface
{
    public function get(int $id);
    public function update(int $id, Request $request);
}
