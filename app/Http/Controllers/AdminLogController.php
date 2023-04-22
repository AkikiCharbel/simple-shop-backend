<?php

namespace App\Http\Controllers;

use App\Data\Resource\LogsData;
use App\Enums\LogActionsEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class AdminLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        $logs = QueryBuilder::for(Activity::class)
            ->with('causer')
            ->allowedFilters([AllowedFilter::exact('event')])
            ->get();
        return LogsData::collection($logs);
    }

    public function logsActions(Request $request): JsonResponse
    {
        return response()->json([
            'data' => LogActionsEnum::all(),
            'status' => Response::HTTP_ACCEPTED,
        ], Response::HTTP_ACCEPTED);
    }
}
