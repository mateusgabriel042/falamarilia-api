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
            ->get();
    }

    public function getAllUser()
    {
        return $this->solicitation
            ->where('user_id', auth()->user()->id)
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
