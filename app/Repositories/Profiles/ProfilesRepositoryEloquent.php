<?php

namespace App\Repositories\Profiles;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfilesRepositoryEloquent implements ProfilesRepositoryInterface
{
    private $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function get(int $id)
    {
        $profile = Profile::find($id)->makeHidden(['user_id']);
        $profile->user = $profile->user->makeHidden(['type', 'created_at', 'updated_at', 'email_verified_at']);
        return $profile;
    }

    public function update(int $id, Request $request)
    {
        return $this->profile
            ->where('id', $id)
            ->update($request->all());
    }
}
