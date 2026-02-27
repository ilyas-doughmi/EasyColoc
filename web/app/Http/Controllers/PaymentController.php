<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function pay(Payments $payment)
    {
        // Only the sender (the person who owes) can mark their own payment
        if ($payment->sender_id !== Auth::id()) {
            abort(403);
        }

        $payment->update(['status' => 'paid']);

        return back()->with('success', 'Paiement marqué comme effectué.');
    }
}
