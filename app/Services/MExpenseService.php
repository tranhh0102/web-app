<?php

namespace App\Services;

use App\Models\MExpense;

class MExpenseService implements BaseServiceInterface {
    public function get($conditions = [])
    {
        return MExpense::all();
    }
    public function insert($requestData = [])
    {
        $result = MExpense::create($requestData);
    }
    public function update($conditions = [], $requestData = [])
    {
        $mExpense = MExpense::where($conditions)->firstOrFail();

        return $mExpense->update($requestData);
    }
    public function delete($conditions = [])
    {
        $mExpense = MExpense::where($conditions)->firstOrFail();

        return $mExpense->delete();
    }
}