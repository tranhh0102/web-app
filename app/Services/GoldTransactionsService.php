<?php

namespace App\Services;

use App\Models\GoalTransaction;

class GoldTransactionsService  implements BaseServiceInterface {
    public function get($conditions = [])
    {
        return GoalTransaction::all();
    }
    public function insert($requestData = [])
    {
        return GoalTransaction::create($requestData);
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