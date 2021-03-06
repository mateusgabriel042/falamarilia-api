<?php

namespace App\Services\Solicitations;

use App\Repositories\Solicitations\SolicitationsRepositoryInterface;
use App\Validators\SolicitationValidator;
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SolicitationsService
{

    private $solicitationsRepository;

    public function __construct(SolicitationsRepositoryInterface $solicitationsRepository)
    {
        $this->solicitationsRepository = $solicitationsRepository;
    }

    public function getAll(Request $request)
    {
        try {

            $page = $request->get('page');
            $waiting = $request->get('waiting');
            $solicitations = $this->solicitationsRepository->getAll($page, $waiting);
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

    public function getAdmin(int $id)
    {
        try {
            $solicitation = $this->solicitationsRepository->getAdmin($id);
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

    public function search(Request $request)
    {
        try {
            $search = $request->get('search');
            $page = $request->get('page');

            if ($search) {
                $solicitation = $this->solicitationsRepository->search($search, $page);
                $countItems = (count($solicitation) > 0) ? true : false;

                if ($countItems) {
                    return response()->json($solicitation, Response::HTTP_OK);
                }
            } else {

                $solicitations = $this->solicitationsRepository->getAll($page);
                $countItems = (count($solicitations) > 0) ? true : false;

                if ($countItems) {
                    return response()->json($solicitations, Response::HTTP_OK);
                } else {
                    return response()->json([], Response::HTTP_OK);
                }
            }
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     SolicitationValidator::NEW_PACKAGE_RULE,
        //     SolicitationValidator::ERROR_MESSAGES
        // );

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        // } else {
        try {

            if ($request->file && $request->file != 'noImage') {
                $image = $request->get('file'); // image base64 encoded
                preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
                $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
                $image = str_replace(' ', '+', $image);
                $imageName = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;

                Storage::disk('solicitations')->put($imageName, base64_decode($image));

                $request['photo'] = 'storage/images/solicitations/' . $imageName;
            } else {
                $request['photo'] = 'noImage';
            }

            $request['protocol'] = time() . '/' . date('Y');
            $request['responsible'] = 0;

            $solicitation = $this->solicitationsRepository->store($request);
            return response()->json($solicitation, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // }
    }

    public function update(int $id, Request $request)
    {
        try {
            $solicitation = $this->solicitationsRepository->update($id, $request);
            return response()->json(['message' => 'Solicita????o atualizada com sucesso!'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
