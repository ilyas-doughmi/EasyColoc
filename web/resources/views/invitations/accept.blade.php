<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 flex-1">
            <div class="w-8 h-8 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-base font-bold text-gray-900 leading-tight">Invitation à rejoindre une colocation</h1>
                <p class="text-xs text-gray-400">Vous avez reçu un Pass VIP 🎉</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Top gradient banner --}}
            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-600"></div>

            <div class="p-8 flex flex-col items-center text-center gap-5">

                {{-- Icon --}}
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>

                {{-- Colocation name --}}
                <div>
                    <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-1">Colocation</p>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $invitation->colocations->name ?? '—' }}</h2>
                    <p class="text-sm text-gray-400 mt-1">Vous avez été invité(e) à rejoindre cette colocation sur EasyColoc.</p>
                </div>

                {{-- Token badge --}}
                <div class="w-full bg-indigo-50 border border-indigo-100 rounded-xl px-5 py-3 flex items-center justify-between gap-3">
                    <div class="text-left">
                        <p class="text-[10px] font-semibold text-indigo-400 uppercase tracking-widest">Code d'invitation</p>
                        <p class="text-sm font-mono font-bold text-indigo-700 mt-0.5 break-all">{{ $invitation->token }}</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                </div>

                {{-- CTA --}}
                @auth
                    <form method="POST" action="{{ route('invitations.join') }}" class="w-full">
                        @csrf
                        <input type="hidden" name="token" value="{{ $invitation->token }}">
                        <button type="submit"
                            class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 transition">
                            ✅ Rejoindre la colocation
                        </button>
                    </form>
                @else
                    <div class="w-full space-y-3">
                        <p class="text-xs text-gray-500">Connectez-vous pour accepter l'invitation.</p>
                        <a href="{{ route('login', ['redirect' => request()->fullUrl()]) }}"
                           class="flex items-center justify-center w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 transition">
                            Se connecter pour rejoindre
                        </a>
                        <a href="{{ route('register') }}"
                           class="flex items-center justify-center w-full py-3 border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl transition">
                            Créer un compte
                        </a>
                    </div>
                @endauth

                @if(session('error'))
                    <p class="text-xs font-medium text-rose-500">{{ session('error') }}</p>
                @endif

            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4">
            Si vous n'attendiez pas cette invitation, ignorez simplement cette page.
        </p>
    </div>

</x-app-layout>
