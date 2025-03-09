<?php

namespace App\Http\Controllers;

use App\Models\CharityTransaction;
use App\Models\Expense;
use App\Models\Goal;
use App\Models\Income;
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
        $search = $request->input('search');
        $date = $request->input('date'); // Lấy ngày từ request

        $dataExpenses = Expense::where('user_id', $userId)->get();
        $dataIncomes = Income::where('user_id', $userId)->get();

        $data = $dataExpenses->merge($dataIncomes);
        return view('pages.home-search',compact('data'));
    }
}
