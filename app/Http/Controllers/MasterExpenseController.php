<?php

namespace App\Http\Controllers;

use App\Services\MExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterExpenseController extends Controller
{
    private $mExpenseService;

    public function __construct(MExpenseService $mExpenseService)
    {
        $this->mExpenseService = $mExpenseService;
    }

    public function index()
    {
        $authUser = Auth::user();
        $userId = $authUser->id;

        $result = $this->mExpenseService->get([
            'user_id' => $userId
        ])->toArray();
        if (count($result) <= 0) {
            $listMIncome = config('default_master_data.m_expense');
            $insertData = [];
            foreach ($listMIncome as $item) {
                $insertData[] = [
                    'name' => $item,
                    'user_id' => $userId
                ];
            }
                if ($this->mExpenseService->insertMany($insertData)) {
                $result = $this->mExpenseService->get([
                    'user_id' => $userId
                ])->toArray();
            }
        }

        return view('pages.add-category-expenses', [
            'list' => $result
        ]);
    }

    public function insert(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($this->mExpenseService->insert($data)) {
            return redirect()->route('mexpense.index')->withSuccess('Thêm thành công');
        }

        return redirect()->route('mexpense.index')->withErrors(['Thêm thất bại']);
    }

    public function delete($id)
    {
        $conditions = [
            'id' => $id
        ];
        if ($this->mExpenseService->delete($conditions)) {
            return redirect()->route('mexpense.index')->withSuccess('Xóa thành công');
        }

        return redirect()->route('mexpense.index')->withErrors(['Xóa thất bại']);
    }
}
