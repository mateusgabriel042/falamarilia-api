<?php

namespace App\Repositories\Notices;

use App\Models\Notice;
use App\Repositories\Notices\NoticesRepositoryInterface;
use Carbon\Carbon;
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
            ->where('expired_at', '>=', Carbon::now())
            ->get();
    }

    public function get(int $id)
    {
        return $this->notice
            ->where('id', $id)
            ->where('expired_at', '>', Carbon::now())
            ->get();
    }

    public function store(Request $request)
    {
        $request['expired_at'] = Carbon::now()->addDays(10);
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
