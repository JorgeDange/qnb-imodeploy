<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amenidade;

class AmenidadeController extends Controller
{
    public function index()
    {
        return response()->json([
            'amenidades' => Amenidade::where('ativo', true)->orderBy('nome')->get(),
        ]);
    }
}
