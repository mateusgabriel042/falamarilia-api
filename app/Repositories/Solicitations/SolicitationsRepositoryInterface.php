<?php

namespace App\Repositories\Solicitations;

use Illuminate\Http\Request;

interface SolicitationsRepositoryInterface
{
    public function getAll($page, $waiting);
    public function getAllUser();
    public function get(int $id);
    public function search($search, $page);
    public function getAdmin(int $id);
    public function store(Request $request);
    public function update(int $id, Request $request);
}
