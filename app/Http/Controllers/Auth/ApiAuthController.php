<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Validators\LoginValidator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Validators\ProfileValidator;
use Illuminate\Http\JsonResponse;

class ApiAuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            ProfileValidator::NEW_PACKAGE_RULE,
            ProfileValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->remember_token = Str::random(10);
        $user->type = $request->get('type') ? $request->get('type') : 1;

        if ($user->save()) {
            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->genre = $request->get('genre') ? $request->get('genre') : 'others';
            $profile->phone = $request->get('phone');
            $profile->cpf = $request->get('cpf');
            $profile->save();
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json(['token' => $token], Response::HTTP_OK);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            LoginValidator::NEW_PACKAGE_RULE,
            LoginValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $request->get('email'))->first();
        if ($user) {
            if (Hash::check($request->get('password'), $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;

                return response()->json(['token' => $token], Response::HTTP_OK);
            } else {

                return response()->json(["message" => "Senha incorreta."], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            return response()->json(["message" => "Usuário não existe."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['message' => 'Você foi desconectado com sucesso!'], Response::HTTP_OK);
    }
}
