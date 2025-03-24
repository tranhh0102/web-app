<?php

namespace App\Services;

use App\Models\MExpense;
use App\Models\MIncome;
use App\Models\Statistic;
use Carbon\Carbon;
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
        if (!isset($data['date'])) {
            $data['date'] = Carbon::now()->toDateString(); // Gán giá trị mặc định
        }
        
        $conditions = [
            'user_id' => Auth::user()->id,
            'month' => Carbon::parse($data['date'])->format('m') ?? Carbon::now()->format('m'),
            'year' => Carbon::parse($data['date'])->format('Y') ?? Carbon::now()->format('Y')
        ];
        
        $statistic = Statistic::where($conditions)->first();
        $currentData = [];
        $data = [
            'user_id' => Auth::user()->id,
            'month' => Carbon::parse($data['date'])->format('m') ?? Carbon::now()->format('m'),
            'year' => Carbon::parse($data['date'])->format('Y') ?? Carbon::now()->format('Y'),
            'old_income_info' => null,
            'old_expense_info' => null,
            'charge' => $data['charge'] ?? 0,
            'm_expense_id' => $data['m_expense_id'] ?? null,
            'm_income_id' => $data['m_income_id'] ?? null,
        ];
        
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

        $fieldList = [
            'user_id',
            'income',
            'goal',
            'expense',
            'charity',
            'income_info',
            'expense_info',
            'month',
            'year'
        ];

        foreach ($data as $key => $value) {
            if (!in_array($key, $fieldList)) {
                unset($data[$key]);
            }
        }

        return [
            'data' => $data,
            'updated_id' => $statistic ? $statistic->id : null
        ];
    }

    private function generateExpenseInfo($data)
    {
        $result = $data['old_expense_info'] ? json_decode($data['old_expense_info'], true) : [];
        $authUser = Auth::user();
        $userId = $authUser->id;
        $mExpsenses = MExpense::where([
            'user_id' => $userId
        ])->get();

        
        foreach ($mExpsenses as $mExpsense) {
            if (isset($data['m_expense_id']) && $data['m_expense_id'] == $mExpsense->id) {
                $result[$mExpsense->id] = ($oldExpenseInfo[$mExpsense->id] ?? 0) + $data['charge'];
                break;
            }
        }
        return $result;
    }

    private function generateIncomeInfo($data)
    {
        $result = $data['old_income_info'] ? json_decode($data['old_income_info'], true) : [];
        $authUser = Auth::user();
        $userId = $authUser->id;

        $mIncomes = MIncome::where([
            'user_id' => $userId
        ])->get();
        foreach ($mIncomes as $mIncome) {
            if (isset($data['m_income_id']) && $data['m_income_id'] == $mIncome->id) {
                $result[$mIncome->id] = ($oldExpenseInfo[$mIncome->id] ?? 0) + $data['charge'];
                break;
            }
        }

        return $result;
    }
}