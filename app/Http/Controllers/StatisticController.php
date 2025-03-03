<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    private $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function index(Request $request)
    {
        $authUser = Auth::user();
        $userId = $authUser->id;

        $result = $this->statisticService->get([
            'user_id' => $userId
        ])->toArray();

        return view('', [
            'list' => $result
        ]);
    }
}
