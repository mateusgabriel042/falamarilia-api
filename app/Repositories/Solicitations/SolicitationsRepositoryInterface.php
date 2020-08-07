<?php

namespace App\Repositories\Solicitations;

use Illuminate\Http\Request;

interface SolicitationsRepositoryInterface
{
    public function getAll();
    public function getAllUser();
    public function get(int $id);
    public function store(Request $request);
    public function update(int $id, Request $request);
}
