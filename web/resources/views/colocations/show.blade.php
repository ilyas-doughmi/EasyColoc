<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 flex-1">
            <div class="w-8 h-8 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <h1 class="text-base font-bold text-gray-900 leading-tight">{{ $colocation->name }}</h1>
                <p class="text-xs text-gray-400">Colocation active</p>
            </div>
        </div>

        {{-- Top-right actions --}}
        <div class="flex items-center gap-2 ml-auto">
            <button onclick="confirmDelete()" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-500 border border-rose-200 hover:bg-rose-50 rounded-lg transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
                Annuler la colocation
            </button>
            <a href="{{ route('colocations.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-semibold rounded-lg transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===== LEFT: Dépenses ===== --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Section header --}}
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-900">Dépenses récentes</h2>
                <button class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-200 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvelle dépense
                </button>
            </div>

            {{-- Filter bar --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-3.5 flex items-center gap-3">
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filtrer par mois :
                </div>
                <select id="monthFilter" class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                    <option value="all">Tous les mois</option>
                    <option value="2">Février 2026</option>
                    <option value="1">Janvier 2026</option>
                    <option value="12">Décembre 2025</option>
                </select>
            </div>

            {{-- Expenses table --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100">
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Titre / Catégorie</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Payeur</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Montant</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50" id="expensesBody">

                        {{-- Mock Row 1 --}}
                        <tr class="hover:bg-gray-50/50 transition expense-row" data-month="2">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Courses Carrefour</p>
                                        <p class="text-xs text-gray-400">Alimentation</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center text-white text-[10px] font-bold">L</div>
                                    <span class="text-sm text-gray-700 font-medium">Lucas</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="text-sm font-bold text-gray-900">87,40 €</span>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-1.5">
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="Modifier">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Supprimer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Mock Row 2 --}}
                        <tr class="hover:bg-gray-50/50 transition expense-row" data-month="2">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Facture EDF</p>
                                        <p class="text-xs text-gray-400">Électricité</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-purple-500 flex items-center justify-center text-white text-[10px] font-bold">S</div>
                                    <span class="text-sm text-gray-700 font-medium">Sara</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="text-sm font-bold text-gray-900">62,00 €</span>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-1.5">
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="Modifier">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Supprimer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Mock Row 3 --}}
                        <tr class="hover:bg-gray-50/50 transition expense-row" data-month="2">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Netflix partagé</p>
                                        <p class="text-xs text-gray-400">Abonnement</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-rose-500 flex items-center justify-center text-white text-[10px] font-bold">A</div>
                                    <span class="text-sm text-gray-700 font-medium">Amine</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="text-sm font-bold text-gray-900">17,99 €</span>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-1.5">
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="Modifier">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Supprimer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Mock Row 4 (January) --}}
                        <tr class="hover:bg-gray-50/50 transition expense-row" data-month="1">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-yellow-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Loyer Janvier</p>
                                        <p class="text-xs text-gray-400">Logement</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center text-white text-[10px] font-bold">M</div>
                                    <span class="text-sm text-gray-700 font-medium">Moi</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="text-sm font-bold text-gray-900">450,00 €</span>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-1.5">
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="Modifier">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button class="p-1.5 rounded-lg text-gray-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Supprimer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                {{-- Empty state (hidden by default) --}}
                <div id="emptyState" class="hidden py-16 flex flex-col items-center gap-2 text-center">
                    <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                    <p class="text-sm text-gray-400 font-medium">Aucune dépense pour le moment.</p>
                </div>

            </div>
        </div>

        {{-- ===== RIGHT PANEL ===== --}}
        <div class="space-y-4">

            {{-- Qui doit à qui --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900">Qui doit à qui ?</h3>
                </div>
                <div class="px-5 py-10 flex flex-col items-center gap-2 text-center">
                    <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                    <p class="text-xs text-gray-400">Aucun remboursement en attente.</p>
                </div>
            </div>

            {{-- Membres --}}
            <div class="bg-slate-900 rounded-2xl p-5 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold">Membres de la coloc</h3>
                    <span class="text-[9px] bg-emerald-500/20 text-emerald-400 font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Actifs</span>
                </div>

                <div class="space-y-3">

                    @foreach ($colocation->User as $user)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">A</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-white truncate">{{$user->name}}</p>
                                <p class="text-[10px] flex items-center gap-1">
                                    @if($user->pivot->role == 'owner')
                                        <span class="text-amber-400">👑</span>
                                        <span class="text-amber-400 font-semibold uppercase tracking-wide text-[9px]">Owner</span>
                                    @elseif($user->pivot->role == 'member')
                                        <span class="text-blue-400">👑</span>
                                        <span class="text-blue-400 font-semibold uppercase tracking-wide text-[9px]">Member</span>
                                    @endif
                                </p>
                            </div>
                            <span class="text-[10px] font-bold text-indigo-400">0 pts</span>
                        </div>
                    @endforeach

                </div>

                <button onclick="openInviteModal()" class="mt-4 flex items-center justify-center gap-2 w-full py-2.5 bg-white/5 hover:bg-white/10 text-white text-xs font-semibold rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Inviter un membre
                </button>
            </div>

        </div>
    </div>

    {{-- ===== INVITATION MODAL ===== --}}
    <div id="inviteModal" class="{{ $errors->any() || session('error') ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Inviter un membre</h3>
                        <p class="text-xs text-gray-400">Envoyez une invitation par email</p>
                    </div>
                </div>
                <button onclick="closeInviteModal()" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body (real POST form) --}}
            <form method="POST" action="{{ route('invitations.send') }}">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

                <div class="px-6 py-5">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Adresse email</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="ami@exemple.com"
                                required
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                            >
                        </div>
                        <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition shadow-sm shadow-indigo-200 whitespace-nowrap">
                            Envoyer
                        </button>
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs font-medium text-rose-500">{{ $message }}</p>
                    @enderror
                    @if(session('error'))
                        <p class="mt-2 text-xs font-medium text-rose-500">{{ session('error') }}</p>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button type="button" onclick="closeInviteModal()" class="px-4 py-2 border border-gray-200 text-sm font-semibold text-gray-700 rounded-xl hover:bg-white transition">
                        Fermer
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Delete confirmation modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <div class="flex flex-col items-center text-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Annuler la colocation ?</h3>
                <p class="text-sm text-gray-500">Cette action est irréversible. Tous les membres seront retirés.</p>
                <div class="flex gap-3 w-full mt-2">
                    <button onclick="closeModal()" class="flex-1 py-2 border border-gray-200 text-sm font-semibold text-gray-700 rounded-xl hover:bg-gray-50 transition">Non, garder</button>
                    <button class="flex-1 py-2 bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold rounded-xl transition">Oui, annuler</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Month filter
        document.getElementById('monthFilter').addEventListener('change', function () {
            const val = this.value;
            const rows = document.querySelectorAll('.expense-row');
            let visible = 0;
            rows.forEach(row => {
                if (val === 'all' || row.dataset.month === val) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });
            document.getElementById('emptyState').classList.toggle('hidden', visible > 0);
        });

        // Delete modal
        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) closeModal();
        });

        // Invite modal
        function openInviteModal() {
            document.getElementById('inviteModal').classList.remove('hidden');
        }
        function closeInviteModal() {
            document.getElementById('inviteModal').classList.add('hidden');
        }
        document.getElementById('inviteModal').addEventListener('click', function (e) {
            if (e.target === this) closeInviteModal();
        });
    </script>

    @if(session('success'))
    <div id="successToast" style="transition:opacity 0.5s" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-slate-900 text-white text-sm font-semibold px-5 py-3 rounded-2xl shadow-2xl">
        <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    <script>setTimeout(() => { const t = document.getElementById('successToast'); if(t) t.style.opacity = '0'; }, 3500);</script>
    @endif

</x-app-layout>
