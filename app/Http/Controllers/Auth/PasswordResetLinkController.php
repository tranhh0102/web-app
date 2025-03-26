<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->session()->regenerate();
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'max:255'],
        ],[
            'email.required' => 'Trường email là bắt buộc.',
            'email.string' => 'Email phải là một chuỗi ký tự.',
            'email.lowercase' => 'Email phải là chữ thường.',
            'email.regex' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn email khác.'
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', 'Chúng tôi đã gửi một link quên mật khẩu tới bạn. Vui lòng vào email xác nhận')
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => 'Email mà bạn nhập có lỗi vui lòng thử lại sau']);
    }
}
