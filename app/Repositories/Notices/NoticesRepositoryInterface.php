<?php

namespace App\Repositories\Notices;

use Illuminate\Http\Request;

interface NoticesRepositoryInterface
{
    public function getAll();
    public function get(int $id);
    public function store(Request $request);
    public function update(int $id, Request $request);
    public function destroy(int $id);
}
