<?php

namespace App\Services;

use App\Models\Expense;

class ExpenseService implements BaseServiceInterface {
    public function get($conditions = [])
    {
        return Expense::all();
    }
    public function insert($requestData = [])
    {
        return Expense::create($requestData);
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