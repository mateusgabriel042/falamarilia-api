<?php

namespace App\Http\Controllers\Badge;

use App\Http\Controllers\Controller;
use App\Models\Solicitation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Throwable;

class BadgesController extends Controller
{
    public function get()
    {
        try {
            $service = auth()->user()->service;
            $symbol = $service !== -1 ? '=' : '!=';

            $solicitationsQty = Solicitation::all()
                ->where('responsible', $symbol, $service)
                ->count();
            $solicitationsAnswered = Solicitation::where('status', '!=', 'Aguardando Resposta')
                ->where('responsible', $symbol, $service)
                ->count();
            $solicitationsUnanswered = Solicitation::where('status', '=', 'Aguardando Resposta')
                ->where('responsible', $symbol, $service)
                ->count();
            $solicitationsLate = Solicitation::where('created_at', '<=', Carbon::now()->subDays(2))
                ->where('status', '=', 'Aguardando Resposta')
                ->where('responsible', $symbol, $service)
                ->count();

            $badges = [
                'solicitationsQty' => $solicitationsQty,
                'solicitationsAnswered' => $solicitationsAnswered,
                'solicitationsUnanswered' => $solicitationsUnanswered,
                'solicitationsLate' => $solicitationsLate,
            ];

            return response()->json($badges, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMonth()
    {
        try {
            $solicitations = Solicitation::selectRaw('year(created_at) year, monthname(created_at) month, month(created_at) number, count(*) data')
                ->where('created_at', '>=', '2020-01-01 00:00:00')
                ->groupBy('year', 'month', 'number')
                ->orderBy('number', 'asc')
                ->get();

            return response()->json($solicitations, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
