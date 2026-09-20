<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use Illuminate\Http\Request;

class ClienteDashboardController extends Controller
{
    public function index()
    {
        return view('cliente.dashboard');
    }
}