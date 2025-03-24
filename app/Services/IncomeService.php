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
        return Income::where($conditions)->get();
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
        try {
            DB::beginTransaction();
            
            $income = Income::where($conditions)->firstOrFail();
            $oldCharge = $income->charge;
            $income->update($requestData);
            $newCharge = $income->charge;
            $requestData['charge'] = $newCharge - $oldCharge;
            // Gọi cập nhật thống kê
            $this->statisticService->calculateStatisticData(Statistic::TYPE_INCOME, $requestData);
    
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function delete($conditions = [])
    {
        try {
            DB::beginTransaction();
            $income = Income::where($conditions)->firstOrFail();
            $oldCharge = $income->charge;
            $newCharge = 0;
            $income['charge'] = $newCharge - $oldCharge;
            $this->statisticService->calculateStatisticData(Statistic::TYPE_INCOME, $income);
            $income->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}