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
        $user = auth()->user();
       $colocations= $user->colocations;
        return view('colocations.index',['colocations'=>$colocations]);
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $colocation = Colocation::create($validated);
        
        $user->colocations()->attach($colocation->id, [
            'role' => 'owner',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        return redirect()->route('colocations.index');
    }
}
