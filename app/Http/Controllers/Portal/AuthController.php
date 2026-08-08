<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('portal.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $customer = Contact::where('email', $request->email)
            ->where('type', 'customer')
            ->where('is_active', true)
            ->where('portal_access', true)
            ->first();

        if ($customer && Hash::check($request->password, $customer->portal_password)) {
            session(['portal_customer_id' => $customer->id]);
            return redirect()->route('portal.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        session()->forget('portal_customer_id');
        return redirect()->route('portal.login');
    }
}
