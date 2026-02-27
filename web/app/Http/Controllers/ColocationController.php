<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColocationStoreRequest;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $col= $user->colocations;
        return view('colocations.index',['colocations'=>$col]);
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function show(Colocation $colocation)
    {
        $myRole = $colocation->User()
                             ->wherePivot('user_id', Auth::id())
                             ->first()?->pivot->role;

        $colocation->load(['User' => function ($q) {
            $q->wherePivot('status', 'active');
        }]);

        return view('colocations.show', [
            'colocation' => $colocation,
            'myRole'     => $myRole,
        ]);
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

    public function leave(Colocation $colocation)
    {
        $user = Auth::user();

        $pivot = $colocation->User()
                            ->wherePivot('user_id', $user->id)
                            ->first()?->pivot;

        if (!$pivot || $pivot->role !== 'member') {
            return redirect()->route('colocations.show', $colocation->id)
                             ->with('error', 'Vous ne pouvez pas quitter cette colocation.');
        }

        $this->memberLeaveColocation($colocation, $user->id);

        return redirect()->route('colocations.index')
                         ->with('success', 'Vous avez quitté la colocation. (-1 réputation)');
    }

    private function memberLeaveColocation(Colocation $colocation, int $userId): void
    {
        $colocation->User()->updateExistingPivot($userId, [
            'status'  => 'left',
            'left_at' => now(),
        ]);

        User::find($userId)->decrement('reputation');
    }

    public function kick(Colocation $colocation, User $user)
    {
        $requester = Auth::user();
        $myPivot = $colocation->User()->wherePivot('user_id', $requester->id)->first()?->pivot;
        if (!$myPivot || $myPivot->role !== 'owner') {
            abort(403);
        }
        $targetPivot = $colocation->User()->wherePivot('user_id', $user->id)->first()?->pivot;
        if (!$targetPivot || $targetPivot->role !== 'member') {
            return back()->with('error', 'Impossible de retirer cet utilisateur.');
        }

        $this->memberLeaveColocation($colocation, $user->id);

        return back()->with('success', "{$user->name} a été retiré de la colocation.");
    }
}
