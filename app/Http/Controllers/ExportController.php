<?php

namespace App\Http\Controllers;

use App\Jobs\ExporterContenusCsv;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function store(): JsonResponse
    {
        ExporterContenusCsv::dispatch();

        return response()->json(['message' => 'export en cours'], 202);
    }

    public function show(): JsonResponse|StreamedResponse
    {
        if (! Storage::disk('local')->exists('exports/contenus.csv')) {
            return response()->json(['message' => 'export pas encore disponible'], 404);
        }

        return Storage::disk('local')->download('exports/contenus.csv');
    }
}
