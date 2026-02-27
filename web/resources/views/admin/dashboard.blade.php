<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration Globale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-lg text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('ban_error_owner'))
                <div x-data="{ open: true }" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                    <div @click.away="open = false" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 text-center pb-8 pt-8">
                        <div class="mx-auto w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Action Impossible</h3>
                        <p class="text-sm text-gray-500 mb-6 px-2">{{ session('ban_error_owner') }}</p>
                        <button @click="open = false" class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-bold rounded-xl transition">
                            Compris
                        </button>
                    </div>
                </div>
            @endif

            {{-- Statistiques --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 mb-1">Colocations</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['colocations'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 mb-1">Utilisateurs</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 mb-1">Total Dépenses</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ number_format($stats['expenses'], 2, ',', ' ') }} €</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 mb-1">Utilisateurs Bannis</p>
                    <p class="text-3xl font-bold text-rose-600">{{ $stats['banned'] }}</p>
                </div>
            </div>

            {{-- Utilisateurs --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-bold text-gray-900">Gestion des Utilisateurs</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                <th class="pb-3 px-2">Nom / Email</th>
                                <th class="pb-3 px-2">Rôle</th>
                                <th class="pb-3 px-2">Réputation</th>
                                <th class="pb-3 px-2">Statut</th>
                                <th class="pb-3 px-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-2">
                                    <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </td>
                                <td class="py-3 px-2">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-2">
                                    <p class="text-sm font-semibold text-indigo-600">{{ $user->reputation }} pts</p>
                                </td>
                                <td class="py-3 px-2">
                                    @if($user->banned_at)
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-medium bg-rose-100 text-rose-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Banni le {{ \Carbon\Carbon::parse($user->banned_at)->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Actif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-2 text-right">
                                    @if($user->role !== 'admin')
                                        @if($user->banned_at)
                                            <form method="POST" action="{{ route('admin.users.unban', $user) }}" class="inline-block">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-semibold rounded-lg transition">
                                                    Débannir
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline-block" onsubmit="return confirm('Bannir cet utilisateur ?');">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold rounded-lg transition">
                                                    Bannir
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400 italic">Protégé</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
