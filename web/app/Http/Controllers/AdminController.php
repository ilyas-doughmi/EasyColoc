<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'colocations' => Colocation::count(),
            'users'       => User::count(),
            'expenses'    => Expense::sum('amount'),
            'banned'      => User::whereNotNull('banned_at')->count(),
        ];

        $users = User::orderBy('name')->get();

        return view('admin.dashboard', compact('stats', 'users'));
    }

    public function ban(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Impossible de bannir un administrateur.');
        }

        $isOwner = $user->colocations()->wherePivot('role', 'owner')->wherePivot('status', 'active')->exists();
        if ($isOwner) {
            return back()->with('ban_error_owner', 'Impossible de bannir cet utilisateur car il est propriétaire d\'une colocation active.');
        }

        $user->update(['banned_at' => now()]);
        return back()->with('success', 'Utilisateur banni avec succès.');
    }

    public function unban(User $user)
    {
        $user->update(['banned_at' => null]);
        return back()->with('success', 'Utilisateur débanni avec succès.');
    }
}
