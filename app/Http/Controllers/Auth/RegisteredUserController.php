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
        $request->session()->regenerate();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'name.required' => 'Trường họ và tên là bắt buộc.',
            'name.string' => 'Họ và tên phải là một chuỗi ký tự.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
        
            'email.required' => 'Trường email là bắt buộc.',
            'email.string' => 'Email phải là một chuỗi ký tự.',
            'email.lowercase' => 'Email phải là chữ thường.',
            'email.regex' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn email khác.',
        
            'password.required' => 'Trường mật khẩu là bắt buộc.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min'      => 'Mật khẩu phải có ít nhất :min ký tự.',
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
