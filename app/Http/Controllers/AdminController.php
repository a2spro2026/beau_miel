<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    private array $accounts = [
        'manager' => [
            'login' => 'admin@beaumiel.com',
            'password' => 'password',
            'label' => 'Manager',
        ],
        'commercial' => [
            'login' => 'commercial@beaumiel.com',
            'password' => 'password',
            'label' => 'Commercial',
        ],
        'facturation' => [
            'login' => 'facturation@beaumiel.com',
            'password' => 'password',
            'label' => 'Facturation',
        ],
    ];

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'statut' => 'required|in:manager,commercial,facturation',
            'login' => 'required|email',
            'password' => 'required|string',
        ]);

        $account = $this->accounts[$data['statut']];

        if (
            strcasecmp($data['login'], $account['login']) !== 0
            || $data['password'] !== $account['password']
        ) {
            return back()->withErrors([
                'login' => 'Identifiants incorrects pour ce statut.',
            ])->withInput($request->except('password'));
        }

        $request->session()->put('admin', [
            'statut' => $data['statut'],
            'label' => $account['label'],
            'login' => $account['login'],
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function dashboard(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('admin')) {
            return redirect('/')->with('admin_open', true);
        }

        return view('admin.dashboard', [
            'admin' => $request->session()->get('admin'),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin');

        return redirect('/');
    }
}
