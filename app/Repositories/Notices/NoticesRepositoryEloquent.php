<?php

namespace App\Repositories\Notices;

use App\Models\Notice;
use App\Repositories\Notices\NoticesRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoticesRepositoryEloquent implements NoticesRepositoryInterface
{
    private $notice;
    private $serviceValidate;

    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
        $this->serviceValidate = auth()->user()->service;
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
        if ($this->serviceValidate == -1) {
            $notice = $this->notice->create($request->all());
            $notice->expired_at = $request->expired_at;
            $notice->save();

            return $this->notice->create($request->all());
        }
        return [];
    }

    public function update(int $id, Request $request)
    {
        if ($this->serviceValidate == -1) {
            return $this->notice
                ->where('id', $id)
                ->update($request->all());
        }
        return [];
    }

    public function destroy(int $id)
    {
        if ($this->serviceValidate == -1) {
            $notice = $this->notice->find($id);
            return $notice->delete();
        }
        return [];
    }
}
