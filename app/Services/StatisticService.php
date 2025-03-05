<?php

namespace App\Services;

use App\Models\Statistic;
use Illuminate\Support\Facades\Auth;

class StatisticService {
    public function get($conditions = [])
    {
        return Statistic::where($conditions)->first();
    }

    public function calculateStatisticData($type, $data)
    {
        $conditions = [
            'user_id' => Auth::user()->id,
            'month' => $data['month'],
            'year' => $data['year'],
        ];
        $statistic = Statistic::where($conditions)->first();
        if ($statistic) {
            $updatedData =  $this->generateStatistic($type, $data, $statistic);
        } else {
            $updatedData =  $this->generateStatistic($type, $data, []);
        }
    }

    private function generateStatistic($type, $data, $currentData = [])
    {
        $goalInfo = $this->generateGoalInfo($data);
        $expenseInfo = $this->generateExpenseInfo($data);
        $incomeInfo = $this->generateIncomeInfo($data);
        $data = [
            'user_id' => Auth::user()->id,
            'income_info' => json_encode($incomeInfo),
            'expense_info' => json_encode($expenseInfo),
            'goal_info' => json_encode($goalInfo),
            'month' => $data['month'],
            'year' => $data['year'],
        ];
        if ($type == Statistic::TYPE_GOAL) {
            $data['goal'] =  $currentData['goal'] ?? 0 + $data['charge'];
        } elseif ($type == Statistic::TYPE_CHARITY) {
            $data['charity'] = $currentData['charity'] ?? 0 + $data['charge'];
        } elseif ($type == Statistic::TYPE_INCOME) {
            $data['income'] = $currentData['income'] ?? 0 +  $data['charge'];
        } elseif ($type == Statistic::TYPE_EXPENSE) {
            $data['expense'] = $currentData['expense'] ?? 0 + $data['charge'];
        }

        return $data;
    }

    private function generateGoalInfo($data)
    {
        return [];
    }

    private function generateExpenseInfo($data)
    {
        return [];
    }

    private function generateIncomeInfo($data)
    {
        return [];
    }
}