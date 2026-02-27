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

   public function accept()
   {
        $token = request('token');

        $invitation = Invitation::where('token', $token)
                                ->where('is_active', true)
                                ->with('colocations')
                                ->first();

        if (!$invitation) {
            abort(404, 'Invitation invalide ou déjà utilisée.');
        }

        if (Auth::check() && Auth::user()->email !== $invitation->email) {
            abort(403, 'Cette invitation ne vous est pas destinée.');
        }

        return view('invitations.accept', ['invitation' => $invitation]);
   }

   public function join(Request $request)
   {
        $token = $request->input('token');

        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation || !$invitation->is_active) {
            return redirect()->back()->with('error', 'Invitation invalide ou déjà utilisée.');
        }

        $user = Auth::user();

        if ($user->email !== $invitation->email) {
            return redirect()->back()->with('error', 'Cette invitation ne vous est pas destinée.');
        }

        $colocation = \App\Models\Colocation::find($invitation->colocation_id);

        if (!$colocation) {
            return redirect()->back()->with('error', 'La colocation associée n\'existe plus.');
        }

        $alreadyMember = $colocation->User()->where('user_id', $user->id)->exists();

        if ($alreadyMember) {
            return redirect()->route('colocations.show', $colocation->id)
                             ->with('error', 'Vous êtes déjà membre de cette colocation.');
        }

        $hasActiveColoc = $user->colocations()
                               ->wherePivot('status', 'active')
                               ->exists();

        if ($hasActiveColoc) {
            return redirect()->back()
                             ->with('error', 'Vous appartenez déjà à une colocation active. Quittez-la avant d\'en rejoindre une nouvelle.');
        }

        $colocation->User()->attach($user->id, [
            'role'      => 'member',
            'status'    => 'active',
            'joined_at' => now(),
        ]);

        $invitation->update(['is_active' => false]);

        return redirect()->route('colocations.show', $colocation->id)
                         ->with('success', 'Bienvenue dans la colocation ! 🎉');
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

        $exists = Invitation::where('email', $request->email)
                            ->where('colocation_id', $activeColocation->id)
                            ->where('is_active', true)
                            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Une invitation active existe déjà pour cet email.');
        }

        $invitation = Invitation::create([
            'email' => $request->email,
            'colocation_id' => $activeColocation->id,
            'token' => $token,
        ]);

        Mail::to($request->email)->send(new ColocationInvitation($invitation, $activeColocation->name));

        return redirect()->back()->with('success', 'Invitation envoyée !');
   }
}
