<?php

namespace App\Services;

use App\Models\CharityTransaction;
use App\Models\Statistic;
use Exception;
use Illuminate\Support\Facades\DB;

class CharityTransactionsService implements BaseServiceInterface {
    protected $statisticService;
    public function __construct(
        StatisticService $statisticService
    ) {
        $this->statisticService = $statisticService;
    }
    public function get($conditions = [])
    {
        return CharityTransaction::all();
    }
    public function insert($requestData = [])
    {
        try {
            DB::beginTransaction();
            CharityTransaction::create($requestData);
            $this->statisticService->calculateStatisticData(Statistic::TYPE_CHARITY, $requestData);
            DB::commit();
            return true;
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return false;
        }
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