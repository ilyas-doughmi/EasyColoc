<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{
    public function index()
    {
        return view('colocations.index');
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        
    }
}
