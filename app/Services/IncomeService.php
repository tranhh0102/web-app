<?php

namespace App\Services;

use App\Models\Income;
use App\Models\Statistic;
use Exception;
use Illuminate\Support\Facades\DB;

class IncomeService implements BaseServiceInterface {
    protected $statisticService;
    public function __construct(
        StatisticService $statisticService
    ) {
        $this->statisticService = $statisticService;
    }
    public function get($conditions = [])
    {
        return Income::all();
    }
    public function insert($requestData = [])
    {
        try {
            DB::beginTransaction();
            Income::create($requestData);
            $this->statisticService->calculateStatisticData(Statistic::TYPE_INCOME, $requestData);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
        
    }
    public function update($conditions = [], $requestData = [])
    {
        $income = Income::where($conditions)->firstOrFail();

        return $income->update($requestData);
    }
    public function delete($conditions = [])
    {
        $income = Income::where($conditions)->firstOrFail();

        return $income->delete();
    }
}