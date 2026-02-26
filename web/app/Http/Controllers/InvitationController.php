<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InvitationStoreRequest;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;

class InvitationController extends Controller
{
    public function store(InvitationStoreRequest $request)
    {
        $invitation = Invitation::create([
            'email' => $request->email,
            'colocation_id' => $request->colocation_id,
            'token' => Str::random(20),
        ]);

        Mail::to($request->email)->send(new InvitationMail($invitation));

        return redirect()->back()->with('success', 'Invitation envoyée !');
    }
}
