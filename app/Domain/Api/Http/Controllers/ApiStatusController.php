<?php

namespace App\Domain\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ApiStatusController extends Controller
{
    public function status(): JsonResponse
    {
        $dbStatus = DB::connection()->getPdo() ? 'Conexão OK' : 'Conexão falhou';
        $ultimaExecucaoCron = Cache::get('ultima_execucao_cron', 'Nunca');
        
        return response()->json([
            'status' => 'API funcionando!',
            'conexao_db' => $dbStatus,
            'ultima_execucao_cron' => $ultimaExecucaoCron,
            'tempo_online' => now()->diffInMinutes(config('app.start_time')) . ' minutos',
            'uso_memoria' => memory_get_usage() . ' bytes',
        ], 200);
    }
}
