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
            @if($myRole === 'owner')
            {{-- Owner: cancel colocation --}}
            <button onclick="confirmDelete()" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-500 border border-rose-200 hover:bg-rose-50 rounded-lg transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
                Annuler la colocation
            </button>
            @elseif($myRole === 'member')
            {{-- Member: leave colocation --}}
            <button onclick="confirmLeave()" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-amber-600 border border-amber-200 hover:bg-amber-50 rounded-lg transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Quitter la colocation
            </button>
            @endif
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
                <button onclick="document.getElementById('expenseForm').classList.toggle('hidden')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-200 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvelle dépense
                </button>
            </div>

            {{-- Inline add expense form --}}
            <div id="expenseForm" class="hidden bg-white rounded-2xl border border-indigo-100 shadow-sm p-5">
                <form method="POST" action="{{ route('expenses.store', $colocation->id) }}">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Titre</label>
                            <input type="text" name="title" required placeholder="Ex: Courses, Loyer..." class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Catégorie</label>
                            <select name="category_id" class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                                <option value="">-- Aucune --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Montant (€)</label>
                            <input type="number" name="amount" required step="0.01" min="0.01" placeholder="0.00" class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Date</label>
                            <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="document.getElementById('expenseForm').classList.add('hidden')" class="px-4 py-2 text-xs font-semibold text-gray-500 border border-gray-200 rounded-xl hover:bg-gray-50 transition">Annuler</button>
                        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">Ajouter</button>
                    </div>
                </form>
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

                        
                        @forelse($colocation->expenses as $expense)
                        <tr class="hover:bg-gray-50/50 transition expense-row" data-month="{{ \Carbon\Carbon::parse($expense->date)->month }}">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $expense->title }}</p>
                                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center text-white text-[10px] font-bold">{{ strtoupper(substr($expense->paidBy->name, 0, 1)) }}</div>
                                    <span class="text-sm text-gray-700 font-medium">{{ $expense->paidBy->name }}</span>
                                    @if($expense->user_id === $myId) <span class="text-[10px] text-indigo-400 font-semibold">(moi)</span> @endif
                                </div>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="text-sm font-bold text-gray-900">{{ number_format($expense->amount, 2) }} €</span>
                                @if($expense->payments->count())
                                <p class="text-[10px] text-gray-400">{{ number_format($expense->amount / ($expense->payments->count() + 1), 2) }} € / pers.</p>
                                @endif
                            </td>
                            <td class="px-6 py-3.5">
                                <div class="space-y-1">
                                    @foreach($expense->payments as $payment)
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] text-gray-500">{{ $payment->sender->name }}</span>
                                        @if($payment->status === 'paid')
                                            <span class="text-[10px] bg-emerald-100 text-emerald-600 font-semibold px-1.5 py-0.5 rounded-full">✓ Payé</span>
                                        @elseif($payment->sender_id === $myId)
                                            <form method="POST" action="{{ route('payments.pay', $payment->id) }}">
                                                @csrf
                                                <button type="submit" class="text-[10px] bg-amber-100 text-amber-600 font-semibold px-1.5 py-0.5 rounded-full hover:bg-amber-200 transition">Marquer payé</button>
                                            </form>
                                        @else
                                            <span class="text-[10px] bg-gray-100 text-gray-400 font-semibold px-1.5 py-0.5 rounded-full">En attente</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-14 text-center">
                                <p class="text-sm text-gray-400 font-medium">Aucune dépense pour le moment.</p>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>{{-- end left col --}}

        {{-- ===== RIGHT PANEL ===== --}}
        <div class="space-y-4">

            @if($myRole === 'owner')
            {{-- Gestion des catégories (Owner only) --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900">Catégories Dépenses</h3>
                </div>
                <div class="p-5">
                    @if($categories->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($categories as $category)
                                <div class="flex items-center gap-1.5 bg-gray-50 border border-gray-200 rounded-lg px-2 py-1">
                                    <span class="text-xs font-medium text-gray-700">{{ $category->name }}</span>
                                    <form method="POST" action="{{ route('categories.destroy', [$colocation->id, $category->id]) }}" class="flex">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Supprimer" class="text-gray-400 hover:text-rose-500 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-400 mb-4">Aucune catégorie personnalisée.</p>
                    @endif

                    <form method="POST" action="{{ route('categories.store', $colocation->id) }}" class="flex gap-2">
                        @csrf
                        <input type="text" name="name" required placeholder="Nouvelle" class="flex-1 text-xs border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                        <button type="submit" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 text-xs font-bold rounded-lg transition">Ajouter</button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Qui doit à qui --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900">Qui doit à qui ?</h3>
                </div>
                <div class="p-5">
                    @if($balances->count() > 0)
                        <div class="space-y-3">
                            @foreach($balances as $balance)
                                <div class="flex items-center justify-between bg-orange-50/50 rounded-xl p-3 border border-orange-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs">
                                            {{ substr($balance->sender_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-900">{{ $balance->sender_name }} <span class="text-gray-500 font-normal">doit à</span> {{ $balance->receiver_name }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-orange-600">{{ number_format($balance->total, 2, ',', ' ') }} €</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center gap-2 text-center py-5">
                            <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                            </svg>
                            <p class="text-xs text-gray-400">Aucun remboursement en attente.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Membres --}}
            <div class="bg-slate-900 rounded-2xl p-5 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold">Membres de la coloc</h3>
                </div>

                <div class="space-y-3">

                    @foreach ($colocation->User as $user)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=123456&color=ffffff" alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-white truncate">{{$user->name}}</p>
                                <p class="text-[10px] flex items-center gap-1">
                                    @if($user->pivot->role == 'owner')
                                        <span class="text-amber-400">👑</span>
                                        <span class="text-amber-400 font-semibold uppercase tracking-wide text-[9px]">Owner</span>
                                    @elseif($user->pivot->role == 'member')
                                        <span class="text-blue-400 font-semibold uppercase tracking-wide text-[9px]">Member</span>
                                    @endif
                                </p>
                            </div>
                            <span class="text-[10px] font-bold text-indigo-400">0 pts</span>
                            @if($myRole === 'owner' && $user->pivot->role === 'member')
                            <form method="POST" action="{{ route('colocations.kick', [$colocation->id, $user->id]) }}">
                                @csrf
                                <button type="submit" title="Retirer" class="p-1 rounded-lg text-rose-400 hover:bg-rose-500/20 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    @endforeach

                </div>

                @if($myRole === 'owner')
                <div class="space-y-2 mt-4">
                    <button onclick="openInviteModal()" class="flex items-center justify-center gap-2 w-full py-2.5 bg-white/5 hover:bg-white/10 text-white text-xs font-semibold rounded-xl transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Inviter un membre
                    </button>
                    
                    <form method="POST" action="{{ route('colocations.cancel', $colocation->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette colocation ? Tous les membres actifs seront marqués comme partis.');">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 text-xs font-semibold rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Annuler la colocation
                        </button>
                    </form>
                </div>
                @endif
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

    {{-- Leave confirmation modal (member only) --}}
    <div id="leaveModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <div class="flex flex-col items-center text-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Quitter la colocation ?</h3>
                <p class="text-sm text-gray-500">Vous perdrez l'accès à cette colocation. Vous pourrez rejoindre une autre coloc par la suite.</p>
                <div class="flex gap-3 w-full mt-2">
                    <button onclick="closeLeaveModal()" class="flex-1 py-2 border border-gray-200 text-sm font-semibold text-gray-700 rounded-xl hover:bg-gray-50 transition">Annuler</button>
                    <form method="POST" action="{{ route('colocations.leave', $colocation->id) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl transition">Oui, quitter</button>
                    </form>
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

        // Leave modal
        function confirmLeave() {
            document.getElementById('leaveModal').classList.remove('hidden');
        }
        function closeLeaveModal() {
            document.getElementById('leaveModal').classList.add('hidden');
        }
        document.getElementById('leaveModal').addEventListener('click', function (e) {
            if (e.target === this) closeLeaveModal();
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
