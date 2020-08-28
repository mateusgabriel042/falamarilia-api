<?php

namespace App\Services\Notices;

use App\Repositories\Notices\NoticesRepositoryInterface;
use App\Validators\NoticeValidator;
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class NoticesService
{

    private $noticesRepository;

    public function __construct(NoticesRepositoryInterface $noticesRepository)
    {
        $this->noticesRepository = $noticesRepository;
    }

    public function getAll()
    {
        try {
            $notices = $this->noticesRepository->getAll();
            $countItems = (count($notices) > 0) ? true : false;

            if ($countItems) {
                return response()->json($notices, Response::HTTP_OK);
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
            $notice = $this->noticesRepository->get($id);
            $countItems = (count($notice) > 0) ? true : false;

            if ($countItems) {
                return response()->json($notice, Response::HTTP_OK);
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
            NoticeValidator::NEW_PACKAGE_RULE,
            NoticeValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try {
                $notice = $this->noticesRepository->store($request);
                return response()->json($notice, Response::HTTP_CREATED);
            } catch (Exception $e) {
                return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            } catch (Throwable $t) {
                return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function update(int $id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            NoticeValidator::NEW_PACKAGE_RULE,
            NoticeValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        try {
            $notice = $this->noticesRepository->update($id, $request);
            return response()->json(['message' => 'Notícia atualizada com sucesso!'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        try {
            $notice = $this->noticesRepository->destroy($id);
            return response()->json(['message' => 'Notícia removida com sucesso!'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
