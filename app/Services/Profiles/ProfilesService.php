<?php

namespace App\Services\Profiles;

use App\Repositories\Profiles\ProfilesRepositoryInterface;
use App\Validators\ProfileValidator;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Throwable;

class ProfilesService
{

    private $profilesRepository;

    public function __construct(ProfilesRepositoryInterface $profilesRepository)
    {
        $this->profilesRepository = $profilesRepository;
    }

    public function get(int $id): JsonResponse
    {
        try {
            $profile = $this->profilesRepository->get($id);
            $countItems = true;

            if ($countItems) {
                return response()->json($profile, Response::HTTP_OK);
            } else {
                return response()->json(null, Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $validator = FacadesValidator::make(
                $request->all(),
                ProfileValidator::NEW_PACKAGE_RULE,
                ProfileValidator::ERROR_MESSAGES
            );

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $profile = $this->profilesRepository->update($id, $request);
            return response()->json($profile, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
