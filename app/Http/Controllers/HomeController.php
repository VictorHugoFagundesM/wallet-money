<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Redireciona à tela inicial da aplicação
     *
     * @return View
     */
    public function index(): View {
        return view("home", ["user" => Auth::user()]);
    }

}
