<?php

namespace App\Services\Services;

use App\Repositories\Services\ServicesRepositoryInterface;
use App\Validators\CategoryValidator;
use App\Validators\ServiceValidator;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ServicesService
{

    private $servicesRepository;

    public function __construct(ServicesRepositoryInterface $servicesRepository)
    {
        $this->servicesRepository = $servicesRepository;
    }

    public function getAll()
    {
        try {
            $services = $this->servicesRepository->getAll();
            $countItems = (count($services) > 0) ? true : false;

            if ($countItems) {
                return response()->json($services, Response::HTTP_OK);
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
            $service = $this->servicesRepository->get($id);
            $countItems = (count($service) > 0) ? true : false;

            if ($countItems) {
                return response()->json($service, Response::HTTP_OK);
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
            ServiceValidator::NEW_PACKAGE_RULE,
            ServiceValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {

                if (!$request->get('icon')) {
                    $request['icon'] = 'noImage';
                }

                $service = $this->servicesRepository->store($request);
                return response()->json($service, Response::HTTP_CREATED);
            } catch (Exception $e) {
                return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            } catch (Throwable $t) {
                return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            CategoryValidator::NEW_PACKAGE_RULE,
            CategoryValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {

                if (!$request->get('icon')) {
                    $request['icon'] = 'noImage';
                }

                $category = $this->servicesRepository->storeCategory($request);
                return response()->json($category, Response::HTTP_CREATED);
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

            if (!$request->get('icon')) {
                $request['icon'] = 'noImage';
            }

            $service = $this->servicesRepository->update($id, $request);
            return response()->json(['message' => 'Serviço atualizado com sucesso!'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateCategory(int $id, $category_id, Request $request)
    {
        try {

            if (!$request->get('icon')) {
                $request['icon'] = 'noImage';
            }

            $category = $this->servicesRepository->updateCategory($id, $category_id, $request);
            return response()->json(['message' => 'Categoria atualizada com sucesso!'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        try {
            $service = $this->servicesRepository->destroy($id);
            return response()->json(['message' => 'Serviço deletado com sucesso!'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroyCategory(int $id, int $category_id)
    {
        try {
            $category = $this->servicesRepository->destroyCategory($id, $category_id);
            return response()->json(['message' => 'Categoria deletada com sucesso!'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
