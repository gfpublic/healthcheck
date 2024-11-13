<?php

namespace Gftech\Healthcheck;

use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Throwable;

class HealthCheckController extends Controller
{
    /**
     * Роут для мониторинга работает ли БД, редис и тд. Будет дергаться извне
     *
     * @param HealthCheckServiceInterface $healthCheckService
     * @return JsonResponse
     */
    public function index(HealthCheckServiceInterface $healthCheckService): JsonResponse
    {
        try {
            $result = $healthCheckService->run();

            return response()->json([
                'result' => $result,
                'success'=> true,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'errors' => [$e->getMessage()],
                'success'=> false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
