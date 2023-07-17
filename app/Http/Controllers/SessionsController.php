<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'

        ]);

        if (! auth()->attempt($attributes)) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'The provided email or password is incorrect',
                ]);
        }

        session()->regenerate();

        return redirect('/')->with('success', 'Welcome back :) !');


    }
    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Bye Bye!');
    }
}
