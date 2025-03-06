<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $dataExpenses = Expense::where('user_id',$userId)->get();
        $dataIncomes = Income::where('user_id',$userId)->get();
        return view('pages.home',compact('dataExpenses','dataIncomes'));
    }

    public function listSearch(Request $request)
    {
        $userId = auth()->user()->id;
        $search = $request->input('search');
        $date = $request->input('date'); // Lấy ngày từ request

        $dataExpenses = Expense::where('user_id',$userId)->get();
        $dataIncomes = Income::where('user_id',$userId)->get();

        return view('pages.home-search');
    }
}
