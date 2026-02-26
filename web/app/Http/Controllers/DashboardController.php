<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $col = $user->colocations()
                            ->where('colocation_user.status', 'active')
                            ->first();
        return view('dashboard.index',['col'=>$col]);
    }
}
