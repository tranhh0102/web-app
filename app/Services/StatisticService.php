<?php

namespace App\Services;

use App\Models\Statistic;

class StatisticService {
    public function get($conditions = [])
    {
        return Statistic::first();
    }
}