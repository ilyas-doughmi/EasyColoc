<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'date'        => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $me = Auth::user();

        // Save expense
        $expense = Expense::create([
            'colocation_id' => $colocation->id,
            'user_id'       => $me->id,
            'category_id'   => $request->category_id,
            'title'         => $request->title,
            'amount'        => $request->amount,
            'date'          => $request->date,
        ]);

        // Find other active members (everyone except me)
        $otherMembers = $colocation->User()
                                   ->wherePivot('status', 'active')
                                   ->where('users.id', '!=', $me->id)
                                   ->get();

        $count = $otherMembers->count();

        if ($count > 0) {
            $split = round($request->amount / ($count + 1), 2); // split evenly including me

            foreach ($otherMembers as $member) {
                Payments::create([
                    'expense_id'  => $expense->id,
                    'sender_id'   => $member->id,  // they owe
                    'receiver_id' => $me->id,       // I paid
                    'amount'      => $split,
                    'status'      => 'pending',
                ]);
            }
        }

        return back()->with('success', 'Dépense ajoutée !');
    }
}
