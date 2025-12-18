<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Hiển thị form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // 2. Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // Cần field password_confirmation
        ]);

        // Tạo user mới
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Đăng nhập luôn sau khi đăng ký
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('tasks.index')->with('success', 'Đăng ký thành công!');
        }

        return redirect()->route('login');
    }

    // 3. Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // 4. Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('tasks.index')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }

    // 5. Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đã đăng xuất!');
    }
}