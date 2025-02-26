<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ExpenseService;
use App\Services\IncomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $expenseService;
    private $incomeService;

    public function __construct(
        ExpenseService $expenseService,
        IncomeService  $incomeService
    ) {
        $this->expenseService = $expenseService;
        $this->incomeService = $incomeService;
    }

    public function incomeTransaction(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($this->incomeService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }

    public function expenseTransaction(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($this->expenseService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }

    public function goalTransaction(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($this->expenseService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }

    public function charityTransaction(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($this->expenseService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }
}
