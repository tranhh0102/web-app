<?php

namespace App\Services;

use App\Models\Goal;
use App\Models\GoalTransaction;
use App\Models\Statistic;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoldTransactionsService  implements BaseServiceInterface
{

    protected $statisticService;

    public function __construct(
        StatisticService $statisticService
    ) {
        $this->statisticService = $statisticService;
    }

    public function get($conditions = [])
    {
        return GoalTransaction::where($conditions)->get();
    }
    public function insert($requestData = [])
    {
        try {
            $userId = Auth::id();
            DB::beginTransaction();
            GoalTransaction::create($requestData);
            //check goal finish change status
            $goal = Goal::with('goalTransactions')->where('user_id', $userId)
                ->where('id', $requestData['m_saving_id'])
                ->first();
            if ($goal) {
                $totalCharge = $goal->goalTransactions->sum('charge');

                if ($totalCharge >= $goal->charge) {
                    $goal->update(['status' => 1]);
                }
            }

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
        try {
            DB::beginTransaction();

            $goalTransaction = GoalTransaction::where($conditions)->firstOrFail();
            $oldCharge = $goalTransaction->charge;
            $goalTransaction->update($requestData);
            $newCharge = $goalTransaction->charge;
            $requestData['charge'] = $newCharge - $oldCharge;
            // Gọi cập nhật thống kê
            $this->statisticService->calculateStatisticData(Statistic::TYPE_GOAL, $requestData);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function delete($conditions = [])
    {
        $goalTransaction = GoalTransaction::where($conditions)->firstOrFail();

        return $goalTransaction->delete();
    }
}
