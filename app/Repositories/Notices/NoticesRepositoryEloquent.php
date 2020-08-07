<?php

namespace App\Repositories\Notices;

use App\Models\Notice;
use App\Repositories\Notices\NoticesRepositoryInterface;
use Illuminate\Http\Request;

class NoticesRepositoryEloquent implements NoticesRepositoryInterface
{
    private $notice;

    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    public function getAll()
    {
        return $this->notice
            ->get();
    }

    public function get(int $id)
    {
        return $this->notice
            ->where('id', $id)
            ->get();
    }

    public function store(Request $request)
    {
        return $this->notice->create($request->all());
    }

    public function update(int $id, Request $request)
    {
        return $this->notice
            ->where('id', $id)
            ->update($request->all());
    }

    public function destroy(int $id)
    {
        $notice = $this->notice->find($id);
        return $notice->delete();
    }
}
