<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\ResetPasswordNotification;
use App\User;
use App\Validators\ResetPasswordValidator;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordController
{
    public function sendPasswordByEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required | email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($user = User::where('email', $request->input('email'))->first()) {
            $password = $this->generatePassword(10);
            $token = Str::random(64);

            $user->password = Hash::make($password);

            if ($user->save()) {

                DB::table(config('auth.passwords.users.table'))->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);

                $details = [
                    'greeting' => 'Olá ' . $user->name,
                    'body' => 'Sua nova senha do App Fala Marília é ' . $password . ' . ',
                ];

                $user->notify(new ResetPasswordNotification($details));

                return response()->json(['message' => 'Senha redefinida com sucesso!'], Response::HTTP_OK);
            }

            return response()->json(['message' => 'Ops, ocorreu um problema ao tentar redefinir sua senha!'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function generatePassword($qtyCaraceters = 8): string
    {
        $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $capitalLetters = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;

        $specialCharacters = str_shuffle('!@#$%*-');

        $characters = $capitalLetters . $smallLetters . $numbers . $specialCharacters;

        $password = substr(str_shuffle($characters), 0, $qtyCaraceters);

        return $password;
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            ResetPasswordValidator::NEW_PACKAGE_RULE,
            ResetPasswordValidator::ERROR_MESSAGES,
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $email = $request->input('email');
        $password = $request->get('password');

        if (User::where('email', $email)->first()) {

            $updatePassword = User::where('email', $email)
                ->update(['password' => Hash::make($password)]);

            return response()->json(['message' => 'Senha redefinida com sucesso!'], Response::HTTP_OK);
        }

        return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
    }
}
