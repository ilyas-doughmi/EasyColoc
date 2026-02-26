<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColocationStoreRequest;
use App\Models\Colocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $col= $user->colocations;
        return view('colocations.index',['col'=>$col]);
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function store(ColocationStoreRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        $hasActiveColocation = $user->colocations()->wherePivot('status', 'active')->exists();

        if($hasActiveColocation){
            return back()->withErrors(['name'=>'already have collocation']);
        }

        $colocation = Colocation::create($validated);
        
        $user->colocations()->attach($colocation->id, [
            'role' => 'owner',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        return redirect()->route('colocations.index');
    }
}
