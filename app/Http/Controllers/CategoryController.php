<?php

namespace App\Http\Controllers;

use App\Models\MExpense;
use App\Models\MIncome;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function expensesCategory()
    {
        $data = MExpense::where('user_id',auth()->user()->id)->get();
        return view('pages.add-category-expenses',compact('data'));
    }

    public function incomeCategory() 
    {
        $data = MIncome::where('user_id',auth()->user()->id)->get();
        return view('pages.add-category-income',compact('data'));
    }

    public function addExpensesCategory(Request $request)
    {
        MExpense::create([
            'name' => $request->name,
            'user_id' => auth()->id(), 
        ]);

        return redirect()->route('category-expenses')->with('success', 'Danh mục chi tiêu đã được thêm.');
    }

    public function addIncomeCategory(Request $request)
    {
        MIncome::create([
            'name' => $request->name,
            'user_id' => auth()->id(), 
        ]);

        return redirect()->route('category-income')->with('success', 'Danh mục chi tiêu đã được thêm.');
    }

    public function expensesDestroy($id)
    {
        $expense = MExpense::findOrFail($id);
        $expense->delete();

        return redirect()->back()->with('success', 'Xóa thành công!');
    }

}
