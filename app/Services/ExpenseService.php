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
            dd($e);
            DB::rollBack();
            return false;
        }
    }
    public function update($conditions = [], $requestData = [])
    {
        $expense = Expense::where($conditions)->firstOrFail();

        return $expense->update($requestData);
    }
    public function delete($conditions = [])
    {
        $expense = Expense::where($conditions)->firstOrFail();

        return $expense->delete();
    }
}