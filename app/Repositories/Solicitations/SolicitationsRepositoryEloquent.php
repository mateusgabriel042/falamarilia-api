<?php

namespace App\Repositories\Solicitations;

use App\Models\Solicitation;
use App\Repositories\Solicitations\SolicitationsRepositoryInterface;
use Illuminate\Http\Request;

class SolicitationsRepositoryEloquent implements SolicitationsRepositoryInterface
{
    private $solicitation;
    private $serviceValidate;
    private $symbol;

    public function __construct(Solicitation $solicitation)
    {
        $this->solicitation = $solicitation;
        $this->serviceValidate = auth()->user()->service;
        $this->symbol = $this->serviceValidate == -1 ? '!=' : '=';
    }

    public function getAll($page, $waiting)
    {
        $perPage = $waiting ? 10000 : 10;
        $selectedPage = $page ? $page : 1;
        $startAt = $waiting ? 0 : $perPage * ($selectedPage - 1);
        $solicitations = $this->solicitation
            ->select(
                'solicitations.id',
                'solicitations.service_id',
                'se.name AS service_name',
                'se.icon AS service_icon',
                'se.color AS service_color',
                'solicitations.user_id',
                'us.name AS user_name',
                'solicitations.category_id',
                'ca.label AS category_name',
                'solicitations.status',
                'solicitations.description',
                'solicitations.photo',
                'solicitations.geolocation',
                'solicitations.geoloc',
                'solicitations.comment',
                'solicitations.protocol',
                'solicitations.created_at',
                'solicitations.updated_at',
            )
            ->join('services AS se', 'se.id', '=', 'solicitations.service_id')
            ->join('categories AS ca', 'ca.id', '=', 'solicitations.category_id')
            ->join('users AS us', 'us.id', '=', 'solicitations.user_id')
            ->where('solicitations.responsible', $this->symbol, $this->serviceValidate)
            ->orderBy('solicitations.id', 'DESC')
            ->offset($startAt)
            ->limit($perPage)
            ->get();

        $solicitationsAmnt = $this->serviceValidate == -1 ? $this->solicitation->count() : $solicitations->count();
        return [
            "meta" => [
                "perPage" => 10,
                "page" => $selectedPage,
                "pagesQty" => ceil($solicitationsAmnt / $perPage),
                "totalRecords" => $solicitationsAmnt,
            ],
            "records" => $solicitations
        ];
    }

    public function getAllUser()
    {
        return $this->solicitation
            ->select(
                'solicitations.id',
                'solicitations.service_id',
                'se.name AS service_name',
                'se.icon AS service_icon',
                'se.color AS service_color',
                'solicitations.user_id',
                // 'pr.name AS user_name',
                'solicitations.category_id',
                'ca.label AS category_name',
                'solicitations.status',
                'solicitations.description',
                'solicitations.photo',
                'solicitations.geolocation',
                'solicitations.geoloc',
                'solicitations.comment',
                'solicitations.protocol',
                'solicitations.created_at',
                'solicitations.updated_at',
            )
            ->join('services AS se', 'se.id', '=', 'solicitations.service_id')
            ->join('categories AS ca', 'ca.id', '=', 'solicitations.category_id')
            // ->join('profiles AS pr', 'pr.id', '=', 'solicitations.user_id')
            ->where('user_id', auth()->user()->id)
            ->orderBy('solicitations.id', 'DESC')
            ->get();
    }

    public function get(int $id)
    {
        return $this->solicitation
            ->select(
                'solicitations.id',
                'solicitations.service_id',
                'se.name AS service_name',
                'se.icon AS service_icon',
                'se.color AS service_color',
                'solicitations.user_id',
                'us.name AS user_name',
                'solicitations.category_id',
                'ca.label AS category_name',
                'solicitations.status',
                'solicitations.description',
                'solicitations.photo',
                'solicitations.geolocation',
                'solicitations.geoloc',
                'solicitations.comment',
                'solicitations.protocol',
                'solicitations.created_at',
                'solicitations.updated_at',
            )
            ->join('services AS se', 'se.id', '=', 'solicitations.service_id')
            ->join('categories AS ca', 'ca.id', '=', 'solicitations.category_id')
            ->join('profiles AS pr', 'pr.id', '=', 'solicitations.user_id')
            ->join('users AS us', 'us.id', '=', 'solicitations.user_id')
            ->where('solicitations.id', $id)
            ->where('solicitations.user_id', auth()->user()->id)
            ->orderBy('solicitations.id', 'DESC')
            ->get();
    }

    public function getAdmin(int $id)
    {
        return $this->solicitation
            ->select(
                'solicitations.id',
                'solicitations.service_id',
                'se.name AS service_name',
                'se.icon AS service_icon',
                'se.color AS service_color',
                'solicitations.user_id',
                'us.name AS user_name',
                'solicitations.category_id',
                'ca.label AS category_name',
                'solicitations.status',
                'solicitations.description',
                'solicitations.photo',
                'solicitations.geolocation',
                'solicitations.geoloc',
                'solicitations.comment',
                'solicitations.protocol',
                'solicitations.responsible',
                'solicitations.created_at',
                'solicitations.updated_at',
            )
            ->where('solicitations.id', $id)
            ->join('services AS se', 'se.id', '=', 'solicitations.service_id')
            ->join('categories AS ca', 'ca.id', '=', 'solicitations.category_id')
            ->join('users AS us', 'us.id', '=', 'solicitations.user_id')
            ->where('solicitations.responsible', $this->symbol, $this->serviceValidate)
            ->get();
    }

    public function search($search, $page)
    {
        $perPage = 10;
        $selectedPage = $page ? $page : 1;
        $startAt = $perPage * ($selectedPage - 1);
        $solicitations = $this->solicitation
            ->select(
                'solicitations.id',
                'solicitations.service_id',
                'se.name AS service_name',
                'se.icon AS service_icon',
                'se.color AS service_color',
                'solicitations.user_id',
                'us.name AS user_name',
                'solicitations.category_id',
                'ca.label AS category_name',
                'solicitations.status',
                'solicitations.description',
                'solicitations.photo',
                'solicitations.geolocation',
                'solicitations.geoloc',
                'solicitations.comment',
                'solicitations.protocol',
                'solicitations.created_at',
                'solicitations.updated_at',
            )
            ->where('solicitations.protocol', 'LIKE', $search . '%')
            ->join('services AS se', 'se.id', '=', 'solicitations.service_id')
            ->join('categories AS ca', 'ca.id', '=', 'solicitations.category_id')
            ->join('users AS us', 'us.id', '=', 'solicitations.user_id')
            ->where('solicitations.responsible', $this->symbol, $this->serviceValidate)
            ->offset($startAt)
            ->limit($perPage)
            ->get();

        $solicitationsAmnt = $this->serviceValidate == -1 ? $this->solicitation->count() : $solicitations->count();

        return [
            "meta" => [
                "perPage" => 10,
                "page" => $selectedPage,
                "pagesQty" => ceil($solicitationsAmnt / $perPage),
                "totalRecords" => $solicitationsAmnt,
            ],
            "records" => $solicitations
        ];
    }

    public function store(Request $request)
    {
        return $this->solicitation->create($request->all());
    }

    public function update(int $id, Request $request)
    {
        if ($this->serviceValidate == -1 || $request->service_id == $this->serviceValidate) {
            return $this->solicitation
                ->where('id', $id)
                ->update($request->all());
        }

        return [];
    }
}
