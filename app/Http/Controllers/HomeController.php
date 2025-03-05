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
        $search = $request->input('search');
        $date = $request->input('date'); // Lấy ngày từ request

        // Fake danh sách 100 bản ghi có ngày giao dịch
        $transactions = [];
        for ($i = 1; $i <= 100; $i++) {
            $transactions[] = [
                'id' => $i,
                'name' => "Transaction $i",
                'amount' => number_format(rand(5, 100), 2),
                'date' => now()->subDays(rand(0, 30))->format('Y-m-d'), // Ngày ngẫu nhiên trong 30 ngày qua
            ];
        }

        // Lọc danh sách theo tên & ngày
        $filteredTransactions = array_filter($transactions, function ($transaction) use ($search, $date) {
            $nameMatch = stripos($transaction['name'], $search) !== false; // Kiểm tra tên có chứa từ khóa không
            $dateMatch = empty($date) || $transaction['date'] === $date; // Kiểm tra ngày có khớp không (nếu có chọn ngày)
            return $nameMatch && $dateMatch;
        });

        // Nhóm theo ngày
        $groupedTransactions = [];
        foreach ($filteredTransactions as $transaction) {
            $groupedTransactions[$transaction['date']][] = $transaction;
        }

        return view('pages.home-search', ['groupedTransactions' => $groupedTransactions]);
    }
}
