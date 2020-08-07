<?php

namespace App\Services\Solicitations;

use App\Repositories\Solicitations\SolicitationsRepositoryInterface;
use App\Validators\SolicitationValidator;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SolicitationsService
{

    private $solicitationsRepository;

    public function __construct(SolicitationsRepositoryInterface $solicitationsRepository)
    {
        $this->solicitationsRepository = $solicitationsRepository;
    }

    public function getAll()
    {
        try {
            if ($this->userType == 2) {
                $category = $this->servicesRepository->destroyCategory($id, $category_id);
                return response()->json(['message' => 'Categoria deletada com sucesso!'], Response::HTTP_OK);
            }

            return response()->json(['message' => 'Você não tem permissão'], Response::HTTP_FORBIDDEN);

            $solicitations = $this->solicitationsRepository->getAll();
            $countItems = (count($solicitations) > 0) ? true : false;

            if ($countItems) {
                return response()->json($solicitations, Response::HTTP_OK);
            } else {
                return response()->json([], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllUser()
    {
        try {
            $solicitations = $this->solicitationsRepository->getAllUser();
            $countItems = (count($solicitations) > 0) ? true : false;

            if ($countItems) {
                return response()->json($solicitations, Response::HTTP_OK);
            } else {
                return response()->json([], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get(int $id)
    {
        try {
            $solicitation = $this->solicitationsRepository->get($id);
            $countItems = (count($solicitation) > 0) ? true : false;

            if ($countItems) {
                return response()->json($solicitation, Response::HTTP_OK);
            } else {
                return response()->json(null, Response::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            SolicitationValidator::NEW_PACKAGE_RULE,
            SolicitationValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $solicitation = $this->solicitationsRepository->store($request);
                return response()->json($solicitation, Response::HTTP_CREATED);
            } catch (Exception $e) {
                return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            } catch (Throwable $t) {
                return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $solicitation = $this->solicitationsRepository->update($id, $request);
            return response()->json(['message' => 'Solicitação atualizada com sucesso!'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
