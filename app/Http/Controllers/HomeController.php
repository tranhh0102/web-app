<?php

namespace App\Http\Controllers;

use App\Models\CharityTransaction;
use App\Models\Expense;
use App\Models\Goal;
use App\Models\GoalTransaction;
use App\Models\Income;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $data = Statistic::where('user_id',$userId)->where('month', $month)->where('year', $year)->first();
        $dataExpenses = Expense::where('user_id',$userId)->whereBetween('date', [Carbon::now()->firstOfMonth(),Carbon::now()->lastOfMonth()])->orderBy('date', 'desc')->get();
        $dataIncomes = Income::where('user_id',$userId)->whereBetween('date', [Carbon::now()->firstOfMonth(),Carbon::now()->lastOfMonth()])->orderBy('date', 'desc')->get();
        return view('pages.home',compact('dataExpenses','dataIncomes','data'));
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
        $dataExpenses = $dataExpenses->orderBy('date', 'desc')->get();
        $dataIncomes = $dataIncomes->orderBy('date', 'desc')->get();
    
        // Gộp danh sách chi tiêu và thu nhập
        $data = $dataExpenses->concat($dataIncomes);
        
        return view('pages.home-search', compact('data'));
    }
    
}
