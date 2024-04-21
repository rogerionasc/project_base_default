<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Login/Index');
    }

    public function auth(Request $request)
    {
//        dd($request);
        $messageEmailPwd = [];
        if (empty($request->email)) {
            $messageEmailPwd['msgemail'] = 'seu e-mail';
        }

        if (empty($request->password)) {
            $messageEmailPwd['password'] = 'sua senha';
        }

        if (empty($request->email) && empty($request->password)) {
            return Redirect::route('login')->with('error', 'Por favor informe '.$messageEmailPwd['msgemail'].' e '.$messageEmailPwd['password']);
        }

        if (empty($request->email)) {
            return Redirect::route('login')->with('error', 'Por favor informe '.$messageEmailPwd['msgemail']);
        }

        if (empty($request->password)) {
            return Redirect::route('login')->with('error', 'Por favor informe '.$messageEmailPwd['password']);
        }

        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            // Verificar se existe um token de sessão
            if ($request->hasSession()) {
                // Verificar se já existe uma sessão válida
                if (auth()->check()) {
                    return Redirect::route('admin.dashboard')->with('info', 'Você já está logado.');
                } else {
                    $this->logout();
                }
            }

            if (auth()->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                if (auth()->user()->account->status === 'active') {
                    $request->session()->regenerate();
                    return Redirect::route('admin.dashboard')->with('success', 'Login realizado com sucesso!');
                } else {
                    auth()->logout(); // Desconectar usuário se a conta estiver inativa
                    session()->invalidate();
                    session()->regenerateToken();
                    return Redirect::route('login')->with('warning', 'Sua conta está inativa. Entre em contato com o suporte.');
                }
            } else {
                return Redirect::route('login')->with('error', 'Verifique sua senha e email.');
            }
        } catch (\Exception $exception) {
            return Redirect::route('login')->with('error', 'Erro interno. Contate o administrador do sistema.');
        }
    }


    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
