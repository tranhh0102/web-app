<?php

namespace App\Http\Controllers;

use App\Services\MIncomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterIncomeController extends Controller
{
    private $mIncomeService;

    public function __construct(MIncomeService $mIncomeService)
    {
        $this->mIncomeService = $mIncomeService;
    }

    public function index()
    {
        $authUser = Auth::user();
        $userId = $authUser->id;

        $result = $this->mIncomeService->get([
            'user_id' => $userId
        ])->toArray();
        
        if (count($result) <= 0) {
            $listMIncome = config('default_master_data.m_income');
            $insertData = [];
            foreach ($listMIncome as $item) {
                $insertData[] = [
                    'name' => $item,
                    'user_id' => $userId
                ];
            }
            if ($this->mIncomeService->insertMany($insertData)) {
                $result = $insertData;
            }
        }

        return view('pages.add-category-income', [
            'list' => $result
        ]);
    }

    public function insert(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($this->mIncomeService->insert($data)) {
            return redirect()->route('mincome.index')->withSuccess('Insert successfully');
        }

        return redirect()->route('mincome.index')->withErrors(['Insert failed']);
    }

    public function delete($id)
    {
        $conditions = [
            'id' => $id
        ];
        if ($this->mIncomeService->delete($conditions)) {
            return redirect()->route('mincome.index')->withSuccess('Remove successfully');
        }

        return redirect()->route('mincome.index')->withErrors(['Remove failed']);
    }
}
