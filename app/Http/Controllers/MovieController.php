<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function getTitles(Request $request, MovieService $movieService): \Illuminate\Support\Collection
    {
        return $movieService->getTitles();
    }

}
