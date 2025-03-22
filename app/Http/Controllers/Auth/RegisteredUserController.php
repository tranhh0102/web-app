<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MExpenseService;
use App\Services\MIncomeService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    private $mExpenseService;
    private $mIncomeService;
    public function __construct(
        MExpenseService $mExpenseService,
        MIncomeService $mIncomeService
    )
    {
        $this->mExpenseService = $mExpenseService;
        $this->mIncomeService = $mIncomeService;
    }
    
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $listMIncome = config('default_master_data.m_expense');
        $insertData = [];
        foreach ($listMIncome as $item) {
            $insertData[] = [
                'name' => $item,
                'user_id' => $user->id
            ];
        }
        $this->mExpenseService->insertMany($insertData);
        $listMIncome = config('default_master_data.m_income');
            $insertData = [];
            foreach ($listMIncome as $item) {
                $insertData[] = [
                    'name' => $item,
                    'user_id' => $user->id
                ];
            }
        $this->mIncomeService->insertMany($insertData);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
