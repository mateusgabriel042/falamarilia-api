<?php

namespace App\Repositories\Profiles;

use App\Models\Profile;
use App\Models\Service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilesRepositoryEloquent implements ProfilesRepositoryInterface
{
    private $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function get(int $id)
    {
        $user = User::find($id);
        $profile = $user->profile;

        if ($user && $profile) {

            $service = Service::where('id', $user->service)->first();

            $return = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'service' => $service ? $service->name : 'Administração',
                'cpf' => $profile->cpf,
                'phone' => $profile->phone,
                'created_at' => $profile->created_at
            ];
        } else {
            $return = [];
        }
        // $profile = Profile::find($id)->makeHidden(['user_id']);
        // $profile->user = $profile->user->makeHidden(['type', 'created_at', 'updated_at', 'email_verified_at']);
        return $return;
    }

    public function update(int $id, Request $request)
    {
        $user = User::where('id', $id)->first();

        if ($request->password != null) {
            $user->update(
                ['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)],
            );
        } else {
            $user->update(
                ['name' => $request->name, 'email' => $request->email],
            );
        }

        return $this->profile
            ->where('id', $id)
            ->update($request->except(['name', 'email', 'password', 'password_confirmation', 'type', 'service']));
    }
}
