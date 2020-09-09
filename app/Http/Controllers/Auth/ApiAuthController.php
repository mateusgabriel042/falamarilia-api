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
use Exception;
use Illuminate\Http\JsonResponse;

class ApiAuthController extends Controller
{
    private $auth;

    public function __construct()
    {
        $this->auth = auth()->user();
    }

    public function authenticated(Request $request): JsonResponse
    {
        return response()->json(['message' => 'Authenticated.'], Response::HTTP_OK);
    }

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
        $user->type = (isset($this->auth->type) && $this->auth->type == 2) ? $request->get('type') : 1;
        $user->service = (isset($this->auth->type) && $this->auth->type == 2) ? $request->get('service') : 0;

        if ($user->save()) {
            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->genre = $request->get('genre') ? $request->get('genre') : 'others';
            $profile->phone = $request->get('phone');
            $profile->cpf = $request->get('cpf');
            $profile->resident = $request->get('resident');
            try {
                $profile->save();
            } catch (Exception $e) {
                $user = User::find($user->id)->delete();
                return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            }

            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            return response()->json(['token' => $token], Response::HTTP_CREATED);
        } else {

            return response()->json(['message' => 'Ops, ocorreu um erro!'], Response::HTTP_BAD_REQUEST);
        }
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

                return response()->json(['token' => $token, 'type' => $user->type, 'service' => $user->service], Response::HTTP_OK);
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

    public function list(): JsonResponse
    {

        $users = User::where('type', '=', 2)
            ->with('service')
            ->where('service', '!=', 0)
            ->get();

        return  response()->json($users, Response::HTTP_OK);
    }

    public function listSimpleUsers(Request $request): JsonResponse
    {
        $page = $request->get('page') ?? 1;
        $perPage = 10;
        $selectedPage = $page ? $page : 1;
        $startAt = $perPage * ($selectedPage - 1);

        $usersAll = User::whereIn('type', [1, 2])
            ->get();

        $users = User::where('type', 1)
            ->with('profile')
            ->where('service', 0)
            ->orderBy('name', 'ASC')
            ->offset($startAt)
            ->limit($perPage)
            ->get();

        $usersAmnt = $usersAll->count();

        return  response()->json([
            "meta" => [
                "perPage" => 10,
                "page" => $selectedPage,
                "pagesQty" => ceil($usersAmnt / $perPage),
                "totalRecords" => $usersAmnt,
            ],
            "records" => $users
        ], Response::HTTP_OK);
    }

    public function listUser($id): JsonResponse
    {

        $user = User::where('id', $id)
            ->with(['service', 'profile'])
            ->get();

        return  response()->json($user, Response::HTTP_OK);
    }

    public function delete(Int $id): JsonResponse
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $profile = Profile::where('user_id', $user->id)->first();

            if ($profile) {
                $user->delete();
                $profile->delete();
                return  response()->json(['message' => 'Usuário Removido com Sucesso.'], Response::HTTP_NO_CONTENT);
            }
        }

        return  response()->json(['message' => 'Usuário não encontrado'], Response::HTTP_NOT_FOUND);
    }

    public function update(int $id, Request $request)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            $user->update($request->all());
            // $user->update(['service', $request->service]);

            $profile = Profile::where('user_id', $user->id)->first();

            if ($profile) {
                $profile
                    ->where('id', $id)
                    ->update($request->except(['name', 'email', 'password', 'password_confirmation', 'type', 'service']));
            }

            return  response()->json(['message' => 'Usuário atualizado'], Response::HTTP_CREATED);
        }

        return  response()->json(['message' => 'Usuário não encontrado'], Response::HTTP_NOT_FOUND);
    }
}
