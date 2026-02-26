<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Mes colocations</h1>
            @if($colocations->count())
            <span class="text-xs bg-indigo-100 text-indigo-700 font-semibold px-2.5 py-1 rounded-full">
                {{ $colocations->count() }} colocation
            </span>
            @endif
        </div>
        <a href="{{ route('colocations.create') }}"
           class="ml-auto inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle
        </a>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        @forelse($colocations as $coloc)

        <div class="bg-white rounded-2xl border {{ $coloc->status === 'cancelled' ? 'border-dashed border-gray-200 opacity-60' : 'border-gray-100 hover:shadow-md' }} shadow-sm overflow-hidden transition flex flex-col">

            <div class="h-1.5 {{ $coloc->status === 'cancelled' ? 'bg-gray-200' : 'bg-gradient-to-r from-indigo-500 to-purple-600' }}"></div>

            <div class="p-5 flex flex-col flex-1">

                {{-- Title row --}}
                <div class="flex items-start gap-3 mb-4">

                    {{-- Icon + crown --}}
                    <div class="relative flex-shrink-0">
                        <div class="w-10 h-10 rounded-xl {{ $coloc->status === 'cancelled' ? 'bg-gray-100' : 'bg-indigo-100' }} flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $coloc->status === 'cancelled' ? 'text-gray-400' : 'text-indigo-600' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        @if($coloc->pivot->role === 'owner')
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-amber-400 rounded-full flex items-center justify-center shadow ring-2 ring-white" title="Vous êtes propriétaire">
                            <svg class="w-2.5 h-2.5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2.5 19L5 10.5l5.5 4L12 4l1.5 10.5 5.5-4 2.5 8.5H2.5z"/>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $coloc->name }}</h3>
                            @if($coloc->pivot->role === 'owner')
                            <span class="text-[9px] bg-amber-100 text-amber-600 font-bold px-1.5 py-0.5 rounded-full uppercase tracking-wide">Owner</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Rejoint le {{ $coloc->pivot->joined_at ? \Carbon\Carbon::parse($coloc->pivot->joined_at)->format('d M Y') : '—' }}
                        </p>
                    </div>

                    {{-- Status badge --}}
                    @if($coloc->status === 'active')
                    <span class="flex-shrink-0 inline-flex items-center gap-1 text-[10px] bg-emerald-100 text-emerald-700 font-semibold px-2 py-1 rounded-full uppercase tracking-wide">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Active
                    </span>
                    @else
                    <span class="flex-shrink-0 inline-flex items-center gap-1 text-[10px] bg-red-100 text-red-500 font-semibold px-2 py-1 rounded-full uppercase tracking-wide">
                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>Annulée
                    </span>
                    @endif
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div class="text-center p-2.5 bg-gray-50 rounded-xl">
                        <p class="text-sm font-bold text-gray-900">{{ $coloc->User->count() }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">membres</p>
                    </div>
                    <div class="text-center p-2.5 bg-gray-50 rounded-xl">
                        <p class="text-sm font-bold text-gray-500 capitalize">{{ $coloc->pivot->role }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">votre rôle</p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-50">
                    @if($coloc->status !== 'cancelled')
                    <a href="{{ route('colocations.show', $coloc) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-white hover:bg-indigo-600 px-3 py-1.5 rounded-lg transition">
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

        @empty

        {{-- Empty state --}}
        <div class="md:col-span-2 xl:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex flex-col items-center justify-center py-24 gap-4 text-center">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Aucune colocation</h3>
                    <p class="text-sm text-gray-400 mt-1">Créez votre première colocation pour commencer.</p>
                </div>
                <a href="{{ route('colocations.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 transition mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer une colocation
                </a>
            </div>
        </div>

        @endforelse

        {{-- CTA card --}}
        @if($colocations->isNotEmpty())
        <a href="{{ route('colocations.create') }}"
           class="bg-white rounded-2xl border-2 border-dashed border-gray-200 shadow-sm flex flex-col items-center justify-center gap-3 text-center p-8 hover:border-indigo-400 hover:bg-indigo-50/30 transition group min-h-[220px]">
            <div class="w-12 h-12 rounded-2xl bg-gray-100 group-hover:bg-indigo-100 flex items-center justify-center transition">
                <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-600 group-hover:text-indigo-700 transition">Créer une colocation</p>
        </a>
        @endif

    </div>
</x-app-layout>
