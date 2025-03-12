<?php

namespace App\Services;

use App\Models\MIncome;

class MIncomeService implements BaseServiceInterface {
    public function get($conditions = [])
    {
        return MIncome::where($conditions)->get();
    }

    public function insertMany($requestData = [])
    {
        return MIncome::insert($requestData);
    }

    public function insert($requestData = [])
    {
        return MIncome::create($requestData);
    }
    public function update($conditions = [], $requestData = [])
    {
        $mIncome = MIncome::where($conditions)->firstOrFail();

        return $mIncome->save($requestData);
    }
    public function delete($conditions = [])
    {
        $mIncome = MIncome::where($conditions)->firstOrFail();

        return $mIncome->delete();
    }
}