<?php

namespace App\Http\Controllers;

use App\Models\CharityTransaction;
use App\Models\Expense;
use App\Models\Goal;
use App\Models\Income;
use App\Models\Statistic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $dataExpenses = Expense::where('user_id',$userId)->get();
        $totalExpenses = $dataExpenses->sum('charge');
        $dataIncomes = Income::where('user_id',$userId)->get();
        $totalIncomes = $dataIncomes->sum('charge');
        $totalCharity = CharityTransaction::where('user_id',$userId)->sum('charge');
        $totalGoal = Goal::where('user_id',$userId)->sum('charge');
        return view('pages.home',compact('dataExpenses','dataIncomes','totalExpenses','totalIncomes','totalCharity','totalGoal'));
    }

    public function listSearch(Request $request)
    {
        $userId = auth()->user()->id;
        $search = $request->input('search'); // Từ khóa tìm kiếm
        $date = $request->input('date'); // Lọc theo ngày
    
        // Lấy danh sách chi tiêu và thu nhập theo user_id
        $dataExpenses = Expense::where('user_id', $userId);
        $dataIncomes = Income::where('user_id', $userId);
    
        // Nếu có từ khóa tìm kiếm, lọc theo tên hoặc mô tả
        if (!empty($search)) {
            $dataExpenses->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
    
            $dataIncomes->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
        }
    
        // Nếu có lọc theo ngày, tìm theo cột created_at hoặc date
        if (!empty($date)) {
            $dataExpenses->whereDate('created_at', $date);
            $dataIncomes->whereDate('created_at', $date);
        }
    
        // Lấy dữ liệu
        $dataExpenses = $dataExpenses->get();
        $dataIncomes = $dataIncomes->get();
    
        // Gộp danh sách chi tiêu và thu nhập
        $data = $dataExpenses->merge($dataIncomes);
    
        return view('pages.home-search', compact('data'));
    }
    
}
