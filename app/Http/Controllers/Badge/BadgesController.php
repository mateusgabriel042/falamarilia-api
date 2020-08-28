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
            $solicitationsQty = Solicitation::all()->count();
            $solicitationsAnswered = Solicitation::where('status', '!=', 'Aguardando Resposta')->count();
            $solicitationsUnanswered = Solicitation::where('status', '=', 'Aguardando Resposta')->count();
            $solicitationsLate = Solicitation::where('created_at', '<=', Carbon::now()->subDays(2))
                ->where('status', '=', 'Aguardando Resposta')->count();

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
            $solicitations = Solicitation::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
                ->where('created_at', '>=', date('Y'))
                ->groupBy('year', 'month')
                ->orderBy('month', 'desc')
                ->get();

            return response()->json($solicitations, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return response()->json(['erro' => $t->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
