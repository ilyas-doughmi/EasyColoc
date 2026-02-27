<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Tableau de bord</h1>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- ===== KPI CARDS ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Réputation --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Score Réputation</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900">142</p>
                    <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                        <span class="text-emerald-500 font-semibold">↑ +12</span> ce mois-ci
                    </p>
                </div>
            </div>

            {{-- Dépenses du mois --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dépenses (Fév)</span>
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900">348,50 €</p>
                    <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                        <span class="text-rose-500 font-semibold">↑ +23%</span> vs janvier
                    </p>
                </div>
            </div>

            {{-- Membres --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Colocataires</span>
                    <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    @if($col)
                        <p class="text-3xl font-bold text-gray-900">{{ $col->User->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $col->name }}</p>
                    @else
                        <p class="text-3xl font-bold text-gray-400">—</p>
                        <p class="text-xs text-gray-400 mt-1">Aucune colocation</p>
                    @endif
                </div>
            </div>

            {{-- Solde --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Solde dû</span>
                    <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-3xl font-bold text-rose-600">-42,50 €</p>
                    <p class="text-xs text-gray-400 mt-1">à rembourser à Lucas</p>
                </div>
            </div>

        </div>

        {{-- ===== BOTTOM ROW ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Dépenses récentes — 2 cols --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-800">Dépenses récentes</h2>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 transition">Voir tout →</a>
                </div>

                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/60">
                            <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Titre / Catégorie</th>
                            <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Payeur</th>
                            <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Montant</th>
                            <th class="text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Coloc</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">

                        {{-- Row 1 --}}
                        <tr class="hover:bg-gray-50/40 transition">
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
                                <span class="text-xs bg-indigo-50 text-indigo-700 font-semibold px-2.5 py-1 rounded-full">Appart Voltaire</span>
                            </td>
                        </tr>

                        {{-- Row 2 --}}
                        <tr class="hover:bg-gray-50/40 transition">
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
                                <span class="text-xs bg-indigo-50 text-indigo-700 font-semibold px-2.5 py-1 rounded-full">Appart Voltaire</span>
                            </td>
                        </tr>

                        {{-- Row 3 --}}
                        <tr class="hover:bg-gray-50/40 transition">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
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
                                <span class="text-xs bg-indigo-50 text-indigo-700 font-semibold px-2.5 py-1 rounded-full">Appart Voltaire</span>
                            </td>
                        </tr>

                        {{-- Row 4 --}}
                        <tr class="hover:bg-gray-50/40 transition">
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-yellow-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Produits ménagers</p>
                                        <p class="text-xs text-gray-400">Entretien</p>
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
                                <span class="text-sm font-bold text-gray-900">34,20 €</span>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="text-xs bg-indigo-50 text-indigo-700 font-semibold px-2.5 py-1 rounded-full">Appart Voltaire</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- Right panel --}}
            <div class="space-y-4">

                {{-- Membres --}}
                @if($col)
                <div class="bg-slate-900 rounded-2xl p-5 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold">Membres de la coloc</h3>
                        <span class="text-[10px] bg-emerald-500/20 text-emerald-400 font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider">{{ $col->User->count() }} Colocataires</span>
                    </div>

                    <div class="space-y-3">
                        @foreach($col->User as $member)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ $member->name }}&rounded=true&background=123456&color=ffffff" alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-white truncate">{{ $member->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $member->role }}</p>
                            </div>
                            <span class="text-[10px] font-bold text-indigo-400">{{ $member->reputation }} pts</span>
                        </div>
                        @endforeach
                    </div>

                    <a href="{{ route('colocations.index') }}" class="mt-4 flex items-center justify-center gap-2 w-full py-2 bg-white/5 hover:bg-white/10 text-white text-xs font-semibold rounded-xl transition">
                        Voir la colocation →
                    </a>
                </div>
                @else
                <div class="bg-slate-900 rounded-2xl p-6 text-white flex flex-col items-center text-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">Pas encore de colocation</p>
                        <p class="text-xs text-slate-400 mt-1">Rejoignez une coloc via une invitation ou créez la vôtre.</p>
                    </div>
                    <a href="{{ route('colocations.index') }}" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition">
                        Voir mes colocations
                    </a>
                </div>
                @endif

            </div>
        </div>

    </div>
</x-app-layout>
