<?php

namespace App\Http\Controllers;

use App\Models\CharityTransaction;
use App\Models\Expense;
use App\Models\Goal;
use App\Models\Income;
use App\Services\CharityTransactionsService;
use App\Services\ExpenseService;
use App\Services\GoalService;
use App\Services\GoldTransactionsService;
use App\Services\IncomeService;
use App\Services\MExpenseService;
use App\Services\MIncomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $expenseService;
    private $incomeService;
    private $charityTransactionsService;
    private $goldTransactionsService;
    private $goalService;
    private $mExpenseService;
    private $mIncomeService;

    public function __construct(
        ExpenseService $expenseService,
        IncomeService  $incomeService,
        CharityTransactionsService $charityTransactionsService,
        GoldTransactionsService $goldTransactionsService,
        GoalService $goalService,
        MExpenseService $mExpenseService,
        MIncomeService $mIncomeService
    ) {
        $this->expenseService = $expenseService;
        $this->incomeService = $incomeService;
        $this->charityTransactionsService = $charityTransactionsService;
        $this->goldTransactionsService = $goldTransactionsService;
        $this->goalService = $goalService;
        $this->mExpenseService = $mExpenseService;
        $this->mIncomeService = $mIncomeService;
    }

    //expense
    public function addExpenses()
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
            if ($this->mExpenseService->insert($insertData)) {
                $result = $insertData;
            }
        }

        return view('pages.add-expenses',compact('result'));
    }

    public function getUpdateExpense($id)
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
            if ($this->mExpenseService->insert($insertData)) {
                $result = $insertData;
            }
        }

        $expense = Expense::find($id);

        return view('pages.expenses.update-expense',compact('result','expense'));
    }

    public function updateExpenses(Request $request,$id)
    {
        $data = $request->only('charge','name','m_expense_id');
        $result = $this->expenseService->update([
            'id' => $id
        ],$data);

        return redirect()->route('home')->withSuccess('Update successfully');
    }

    //income
    public function addIncome()
    {
        $authUser = Auth::user();
        $userId = $authUser->id;

        $result = $this->mIncomeService->get([
            'user_id' => $userId
        ])->toArray();
        
        if (count($result) <= 0) {
            $listMIncome = config('default_master_data.m_income');
            $insertData = [];
            foreach ($listMIncome as $item) {
                $insertData[] = [
                    'name' => $item,
                    'user_id' => $userId
                ];
            }
            if ($this->mIncomeService->insert($insertData)) {
                $result = $insertData;
            }
        }

        return view('pages.add-income',compact('result'));
    }

    public function getUpdateIncome($id)
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
            if ($this->mExpenseService->insert($insertData)) {
                $result = $insertData;
            }
        }

        $income = Income::find($id);

        return view('pages.expenses.update-income',compact('result','income'));
    }

    public function updateIncome(Request $request,$id)
    {
        $data = $request->only('charge','name','m_expense_id');
        $result = $this->incomeService->update([
            'id' => $id
        ],$data);

        return redirect()->route('home')->withSuccess('Update successfully');
    }

    public function incomeTransaction(Request $request)
    {
        $data = $request->only('charge','name','m_income_id');
        $data['user_id'] = Auth::user()->id;
        if ($this->incomeService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }

    public function expenseTransaction(Request $request)
    {
        $data = $request->only('charge','name','m_expense_id');
        $data['user_id'] = Auth::user()->id;
        if ($this->expenseService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }

    //goal
    public function addGoal()
    {
        return view('pages.goal.add-goal');
    }

    public function listGoal()
    {
        $data = Goal::with('goalTransactions')->get();
        return view('pages.goal.list-goal',compact('data'));
    }

    public function addGoalTransaction($id)
    {
        $goal = Goal::find($id);
        return view('pages.goal.add-goal-transaction',compact('goal'));
    }

    public function goalTransaction(Request $request,$id)
    {
        $data = $request->only('charge');
        $data['user_id'] = Auth::user()->id;
        $data['m_saving_id'] = $id;
        if ($this->goldTransactionsService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }

    public function createGoal(Request $request)
    {
        $data = $request->only('charge','name','due_date');
        $data['user_id'] = Auth::user()->id;
        if ($this->goalService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }

    //charity
    public function addCharity()
    {
        return view('pages.charity.add-charity');
    }

    public function listCharity()
    {
        $data = CharityTransaction::all();
        $totalCharge = $data->sum('charge');
        return view('pages.charity.list-charity',compact('data','totalCharge'));
    }

    public function charityTransaction(Request $request)
    {
        $data = $request->only('charge','name');
        $data['user_id'] = Auth::user()->id;
        if ($this->charityTransactionsService->insert($data)) {
            return redirect()->route('home')->withSuccess('Insert successfully');
        }

        return redirect()->route('home')->withErrors(['Insert failed']);
    }
}
