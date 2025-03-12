<?php

namespace App\Services;

use App\Models\GoalTransaction;
use App\Models\Statistic;
use Exception;
use Illuminate\Support\Facades\DB;

class GoldTransactionsService  implements BaseServiceInterface {

    protected $statisticService;

    public function __construct
    (
        StatisticService $statisticService
    )
    {
        $this->statisticService = $statisticService;
    }
    
    public function get($conditions = [])
    {
        return GoalTransaction::where($conditions)->get();
    }
    public function insert($requestData = [])
    {
        try {
            DB::beginTransaction();
            GoalTransaction::create($requestData);
            $this->statisticService->calculateStatisticData(Statistic::TYPE_GOAL, $requestData);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function update($conditions = [], $requestData = [])
    {
        $goalTransaction = GoalTransaction::where($conditions)->firstOrFail();

        return $goalTransaction->save($requestData);
    }
    public function delete($conditions = [])
    {
        $goalTransaction = GoalTransaction::where($conditions)->firstOrFail();

        return $goalTransaction->delete();
    }
}