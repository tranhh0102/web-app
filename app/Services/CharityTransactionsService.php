<?php

namespace App\Services;

use App\Models\CharityTransaction;

class CharityTransactionsService implements BaseServiceInterface {
    public function get($conditions = [])
    {
        return CharityTransaction::all();
    }
    public function insert($requestData = [])
    {
        return CharityTransaction::insert($requestData);
    }
    public function update($conditions = [], $requestData = [])
    {
        $charityTransaction = CharityTransaction::where($conditions)->firstOrFail();

        return $charityTransaction->save($requestData);
    }
    public function delete($conditions = [])
    {
        $charityTransaction = CharityTransaction::where($conditions)->firstOrFail();

        return $charityTransaction->delete();
    }
}