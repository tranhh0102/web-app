<?php

namespace App\Http\Controllers;

use App\Models\MExpense;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function expensesCategory()
    {
        return view('pages.add-category-expenses');
    }

    public function incomeCategory() 
    {
        return view('pages.add-category-income');
    }

    public function addExpensesCategory(Request $request)
    {
        $name = $request->name;

        MExpense::create([
            'name' => $request->name,
            'user_id' => auth()->id(), 
        ]);

        return redirect()->route('category-expenses')->with('success', 'Danh mục chi tiêu đã được thêm.');
    }
}
