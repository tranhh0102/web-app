<?php

namespace App\Services;

use App\Models\MExpense;

class MExpenseService implements BaseServiceInterface {
    public function get($conditions = [])
    {
        return MExpense::where($conditions)->get();
    }

    public function insertMany($requestData = [])
    {
        return MExpense::insert($requestData);
    }

    public function insert($requestData = [])
    {
        return MExpense::create($requestData);
    }
    public function update($conditions = [], $requestData = [])
    {
        $mExpense = MExpense::where($conditions)->firstOrFail();

        return $mExpense->save($requestData);
    }
    public function delete($conditions = [])
    {
        $mExpense = MExpense::where($conditions)->firstOrFail();

        return $mExpense->delete();
    }
}