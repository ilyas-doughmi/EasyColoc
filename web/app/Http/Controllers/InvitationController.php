<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InvitationStoreRequest;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ColocationInvitation;

class InvitationController extends Controller
{

   public function codeGenerator()
   {
        $token = Str::random(32);
        return $token;
   }

   public function sendInvitation(Request $request)
   {
        $request->validate([
            'email' => 'required|email',
            'colocation_id' => 'required|exists:colocations,id',
        ]);
        
        $user = Auth::user();

        $activeColocation = $user->colocations()->wherePivot('status', 'active')->withPivot('role')->first();

        if (!$activeColocation) {
            return redirect()->back()->with('error', 'Vous devez avoir une colocation active pour envoyer des invitations.');
        }

        if($activeColocation->pivot->role != 'owner'){
            return redirect()->back()->with('error', 'Vous devez être owner pour envoyer des invitations.');
        }

        $token = $this->codeGenerator();

        $invitation = Invitation::create([
            'email' => $request->email,
            'colocation_id' => $activeColocation->id,
            'token' => $token,
        ]);

        Mail::to($request->email)->send(new ColocationInvitation($invitation, $activeColocation->name));

        return redirect()->back()->with('success', 'Invitation envoyée !');
   }
}
