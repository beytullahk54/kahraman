<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{

    public function __construct()
    {
        // Tüm işlemler için oturum kontrolü (giriş yapmış olma) zorunlu kılınır.
        $this->middleware('auth');
    }
    
    public function index(): Response
    {
        return Inertia::render('Dashboard/Index');
    }
}
