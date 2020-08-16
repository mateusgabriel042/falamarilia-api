<?php

namespace App\Repositories\Solicitations;

use App\Models\Solicitation;
use App\Repositories\Solicitations\SolicitationsRepositoryInterface;
use Illuminate\Http\Request;

class SolicitationsRepositoryEloquent implements SolicitationsRepositoryInterface
{
    private $solicitation;

    public function __construct(Solicitation $solicitation)
    {
        $this->solicitation = $solicitation;
    }

    public function getAll()
    {
        return $this->solicitation
            ->orderBy('id', 'desc')
            ->get();
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
                'solicitations.category_id',
                'ca.label AS category_name',
                'solicitations.status',
                'solicitations.description',
                'solicitations.photo',
                'solicitations.geolocation',
                'solicitations.comment',
                'solicitations.protocol',
                'solicitations.created_at',
                'solicitations.updated_at',
            )
            ->join('services AS se', 'se.id', '=', 'solicitations.service_id')
            ->join('categories AS ca', 'ca.id', '=', 'solicitations.category_id')
            ->where('user_id', auth()->user()->id)
            ->orderBy('solicitations.id', 'DESC')
            ->get();
    }

    public function get(int $id)
    {
        return $this->solicitation
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->get();
    }

    public function store(Request $request)
    {
        // dd($request->photo);
        return $this->solicitation->create($request->all());
    }

    public function update(int $id, Request $request)
    {
        return $this->solicitation
            ->where('id', $id)
            ->update($request->all());
    }
}
