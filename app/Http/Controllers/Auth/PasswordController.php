<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('auth.change-password');
    }
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
    
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
    
        Auth::logout(); // Đăng xuất người dùng
    
        $request->session()->invalidate(); // Hủy session
        $request->session()->regenerateToken(); // Tạo token mới
    
        return redirect()->route('login')->with('status', 'Đổi mât khẩu thành công');
    }
}
