<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\Statistic;
use Exception;
use Illuminate\Support\Facades\DB;

class ExpenseService implements BaseServiceInterface {
    protected $statisticService;
    public function __construct(
        StatisticService $statisticService
    ) {
        $this->statisticService = $statisticService;
    }
    public function get($conditions = [])
    {
        return Expense::where($conditions)->get();
    }
    public function insert($requestData = [])
    {
        try {
            DB::beginTransaction();
            Expense::create($requestData);
            $this->statisticService->calculateStatisticData(Statistic::TYPE_EXPENSE, $requestData);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function update($conditions = [], $requestData = [])
    {
        $expense = Expense::where($conditions)->firstOrFail();
        
        try {
            DB::beginTransaction();
            $oldCharge = $expense->charge;
            $expense->update($requestData);
            $newCharge = $expense->charge;
            $chargeStatistic = $newCharge - $oldCharge;
            $requestData['charge'] = $chargeStatistic;
            $this->statisticService->calculateStatisticData(Statistic::TYPE_EXPENSE, $requestData);
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
            $expense = Expense::where($conditions)->firstOrFail();
            $oldCharge = $expense->charge;
            $newCharge = 0;
            $expense['charge'] = $newCharge - $oldCharge;
            $this->statisticService->calculateStatisticData(Statistic::TYPE_INCOME, $expense);
            $expense->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}