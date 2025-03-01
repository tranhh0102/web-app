<?php

namespace App\Http\Controllers;

use App\Services\CharityTransactionsService;
use App\Services\ExpenseService;
use App\Services\GoalService;
use App\Services\GoldTransactionsService;
use App\Services\IncomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $expenseService;
    private $incomeService;
    private $charityTransactionsService;
    private $goldTransactionsService;
    private $goalService;

    public function __construct(
        ExpenseService $expenseService,
        IncomeService  $incomeService,
        CharityTransactionsService $charityTransactionsService,
        GoldTransactionsService $goldTransactionsService,
        GoalService $goalService
    ) {
        $this->expenseService = $expenseService;
        $this->incomeService = $incomeService;
        $this->charityTransactionsService = $charityTransactionsService;
        $this->goldTransactionsService = $goldTransactionsService;
        $this->goalService = $goalService;
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
        if ($this->goldTransactionsService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }

    public function charityTransaction(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($this->charityTransactionsService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }
    
    public function createGoal(Request $request)
    {
        
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($this->goalService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }
}
