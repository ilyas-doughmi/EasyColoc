<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Mes colocations</h1>
            <span class="text-xs bg-indigo-100 text-indigo-700 font-semibold px-2.5 py-1 rounded-full">3 au total</span>
        </div>
        <a href="{{ route('colocations.create') }}"
           class="ml-auto inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 transition-all duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle
        </a>
    </x-slot>

    {{-- Mock data --}}
    @php
    $colocations = [
        [
            'name'     => 'Appart Voltaire',
            'city'     => 'Paris 11e',
            'status'   => 'active',
            'is_owner' => true,
            'members'  => [
                ['initial' => 'L', 'color' => 'bg-indigo-500'],
                ['initial' => 'S', 'color' => 'bg-purple-500'],
                ['initial' => 'A', 'color' => 'bg-rose-500'],
                ['initial' => 'J', 'color' => 'bg-amber-500'],
            ],
            'expenses' => '348 €',
            'balance'  => '-42 €',
            'balance_class' => 'text-rose-600',
            'accent'   => ['from' => 'from-indigo-500', 'to' => 'to-purple-600', 'icon_bg' => 'bg-indigo-100', 'icon_text' => 'text-indigo-600'],
        ],
        [
            'name'     => 'Studio Nation',
            'city'     => 'Paris 20e',
            'status'   => 'active',
            'is_owner' => false,
            'members'  => [
                ['initial' => 'M', 'color' => 'bg-emerald-500'],
                ['initial' => 'R', 'color' => 'bg-teal-500'],
            ],
            'expenses' => '124 €',
            'balance'  => '+18 €',
            'balance_class' => 'text-emerald-600',
            'accent'   => ['from' => 'from-emerald-400', 'to' => 'to-teal-500', 'icon_bg' => 'bg-emerald-100', 'icon_text' => 'text-emerald-600'],
        ],
        [
            'name'     => 'Coloc Oberkampf',
            'city'     => 'Paris 11e',
            'status'   => 'cancelled',
            'is_owner' => true,
            'members'  => [
                ['initial' => 'N', 'color' => 'bg-gray-400'],
                ['initial' => 'T', 'color' => 'bg-gray-400'],
                ['initial' => 'K', 'color' => 'bg-gray-400'],
            ],
            'expenses' => '0 €',
            'balance'  => '0 €',
            'balance_class' => 'text-gray-400',
            'accent'   => ['from' => 'from-gray-300', 'to' => 'to-gray-400', 'icon_bg' => 'bg-gray-100', 'icon_text' => 'text-gray-400'],
        ],
    ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        @foreach($colocations as $coloc)
        @php $cancelled = $coloc['status'] === 'cancelled'; @endphp

        <div class="bg-white rounded-2xl border {{ $cancelled ? 'border-dashed border-gray-200' : 'border-gray-100' }} shadow-sm overflow-hidden {{ $cancelled ? 'opacity-70' : 'hover:shadow-md' }} transition group flex flex-col">

            {{-- Gradient top band --}}
            <div class="h-1.5 bg-gradient-to-r {{ $coloc['accent']['from'] }} {{ $coloc['accent']['to'] }}"></div>

            <div class="p-5 flex flex-col flex-1">

                {{-- Top row: icon + title + status --}}
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl {{ $coloc['accent']['icon_bg'] }} flex items-center justify-center flex-shrink-0 relative">
                        <svg class="w-5 h-5 {{ $coloc['accent']['icon_text'] }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        {{-- Crown badge if owner --}}
                        @if($coloc['is_owner'])
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-amber-400 rounded-full flex items-center justify-center shadow-sm ring-2 ring-white" title="Vous êtes propriétaire">
                            <svg class="w-2.5 h-2.5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2.5 19L5 10.5l5.5 4L12 4l1.5 10.5 5.5-4L21.5 19H2.5z"/>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $coloc['name'] }}</h3>
                            @if($coloc['is_owner'])
                            <span class="text-[9px] bg-amber-100 text-amber-600 font-bold px-1.5 py-0.5 rounded-full uppercase tracking-wide">Owner</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">📍 {{ $coloc['city'] }}</p>
                    </div>

                    {{-- Status badge --}}
                    @if($coloc['status'] === 'active')
                    <span class="flex-shrink-0 inline-flex items-center gap-1 text-[10px] bg-emerald-100 text-emerald-700 font-semibold px-2 py-1 rounded-full uppercase tracking-wide">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Active
                    </span>
                    @else
                    <span class="flex-shrink-0 inline-flex items-center gap-1 text-[10px] bg-gray-100 text-gray-500 font-semibold px-2 py-1 rounded-full uppercase tracking-wide">
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>Annulée
                    </span>
                    @endif
                </div>

                {{-- Stats grid --}}
                <div class="grid grid-cols-3 gap-2 mb-4">
                    <div class="text-center p-2.5 bg-gray-50 rounded-xl">
                        <p class="text-sm font-bold text-gray-900">{{ count($coloc['members']) }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">membres</p>
                    </div>
                    <div class="text-center p-2.5 bg-gray-50 rounded-xl">
                        <p class="text-sm font-bold text-gray-900">{{ $coloc['expenses'] }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">ce mois</p>
                    </div>
                    <div class="text-center p-2.5 bg-gray-50 rounded-xl">
                        <p class="text-sm font-bold {{ $coloc['balance_class'] }}">{{ $coloc['balance'] }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">solde</p>
                    </div>
                </div>

                {{-- Footer: avatars + action --}}
                <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-50">
                    <div class="flex -space-x-2">
                        @foreach($coloc['members'] as $m)
                        <div class="w-7 h-7 rounded-full {{ $m['color'] }} border-2 border-white flex items-center justify-center text-white text-[10px] font-bold shadow-sm">
                            {{ $m['initial'] }}
                        </div>
                        @endforeach
                    </div>

                    @if(!$cancelled)
                    <a href="#"
                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-white hover:bg-indigo-600 px-3 py-1.5 rounded-lg transition">
                        Ouvrir
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @else
                    <span class="text-xs text-gray-400 italic">Archivée</span>
                    @endif
                </div>

            </div>
        </div>
        @endforeach

        {{-- CTA card --}}
        <a href="{{ route('colocations.create') }}"
           class="bg-white rounded-2xl border-2 border-dashed border-gray-200 shadow-sm flex flex-col items-center justify-center gap-3 text-center p-8 hover:border-indigo-400 hover:bg-indigo-50/30 transition group min-h-[220px]">
            <div class="w-12 h-12 rounded-2xl bg-gray-100 group-hover:bg-indigo-100 flex items-center justify-center transition">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-600 group-hover:text-indigo-700 transition">Créer une colocation</p>
                <p class="text-xs text-gray-400 mt-1 max-w-[160px]">Invitez vos colocataires et gérez vos dépenses.</p>
            </div>
        </a>

    </div>

</x-app-layout>
