<?php

namespace App\Services;

use App\Models\MExpense;
use App\Models\MIncome;
use App\Models\Statistic;
use Illuminate\Support\Facades\Auth;

class StatisticService {

    public function __construct() {
    }
    public function get($conditions = [])
    {
        return Statistic::where($conditions)->first();
    }

    public function calculateStatisticData($type, $data)
    {
        $result =  $this->generateStatistic($type, $data);
        !$result['updated_id'] ? Statistic::insert($result['data']) : Statistic::where('id', $result['updated_id'])->update($result['data']);
    }

    private function generateStatistic($type, $data)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'month' => $data['month'],
            'year' => $data['year']
        ];
        
        $statistic = Statistic::where($data)->first();
        $currentData = [];
        if ($statistic) {
            $data['old_income_info'] = $statistic['income_info'];
            $data['old_expense_info'] = $statistic['expense_info'];
            $currentData = $statistic;
        }

        if ($type == Statistic::TYPE_GOAL) {
            $data['goal'] =  ($currentData['goal'] ?? 0) + $data['charge'];
        } elseif ($type == Statistic::TYPE_CHARITY) {
            $data['charity'] = ($currentData['charity'] ?? 0) + $data['charge'];
        } elseif ($type == Statistic::TYPE_INCOME) {
            $incomeInfo = $this->generateIncomeInfo($data);
            $data['income_info'] = json_encode($incomeInfo);
            $data['income'] = ($currentData['income'] ?? 0) +  $data['charge'];
        } elseif ($type == Statistic::TYPE_EXPENSE) {
            $expenseInfo = $this->generateExpenseInfo($data);
            $data['expense_info'] = json_encode($expenseInfo);
            $data['expense'] = ($currentData['expense'] ?? 0) + $data['charge'];
        }

        return [
            'data' => $data,
            'updated_id' => $statistic ? $statistic->id : null
        ];
    }

    private function generateExpenseInfo($data)
    {
        $result = json_decode($data['old_expense_info'], true);

        $authUser = Auth::user();
        $userId = $authUser->id;

        $mExpsenses = MExpense::where([
            'user_id' => $userId
        ])->get();
        
        foreach ($mExpsenses as $mExpsense) {
            if ($result['m_expense_id'] == $mExpsense->id) {
                $result[$mExpsense->id] = ($oldExpenseInfo[$mExpsense->id] ?? 0) + $data['charge'];
                break;
            }
        }

        return $result;
    }

    private function generateIncomeInfo($data)
    {
        $result = json_decode($data['old_income_info'], true);

        $authUser = Auth::user();
        $userId = $authUser->id;

        $mIncomes = MIncome::where([
            'user_id' => $userId
        ])->get();
        
        foreach ($mIncomes as $mInome) {
            if ($result['m_income_id'] == $mInome->id) {
                $result[$mInome->id] = ($oldExpenseInfo[$mInome->id] ?? 0) + $data['charge'];
                break;
            }
        }

        return $result;
    }
}