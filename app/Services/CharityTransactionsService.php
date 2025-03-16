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
        return CharityTransaction::where($conditions)->get();
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
            DB::rollBack();
            return false;
        }
    }
    public function update($conditions = [], $requestData = [])
    {
        try {
            DB::beginTransaction();
            $charityTransaction = CharityTransaction::where($conditions)->firstOrFail();
            $oldCharge = $charityTransaction->charge;
            $charityTransaction->update($requestData);
            $newCharge = $charityTransaction->charge;
            $requestData['charge'] = $newCharge - $oldCharge;
            // Gọi cập nhật thống kê
            $this->statisticService->calculateStatisticData(Statistic::TYPE_CHARITY, $requestData);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function delete($conditions = [])
    {
        try {
            DB::beginTransaction();
        
            $charityTransaction = CharityTransaction::where($conditions)->firstOrFail();
            
            $oldCharge = $charityTransaction->charge;
        
            $charityTransaction->charge = -$oldCharge;  
        
            $this->statisticService->calculateStatisticData(Statistic::TYPE_CHARITY, $charityTransaction);
        
            $charityTransaction->delete();
        
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}