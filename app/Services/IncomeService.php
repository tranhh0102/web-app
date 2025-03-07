<?php

namespace App\Services;

use App\Models\Income;

class IncomeService implements BaseServiceInterface {
    public function get($conditions = [])
    {
        return Income::all();
    }
    public function insert($requestData = [])
    {
        return Income::create($requestData);
    }
    public function update($conditions = [], $requestData = [])
    {
        $income = Income::where($conditions)->firstOrFail();

        return $income->update($requestData);
    }
    public function delete($conditions = [])
    {
        $income = Income::where($conditions)->firstOrFail();

        return $income->delete();
    }
}