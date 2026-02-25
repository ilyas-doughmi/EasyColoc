<x-guest-layout>
    <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl border border-white/30 p-10 transition-transform duration-300 hover:-translate-y-1">

        {{-- Logo & Title --}}
        <div class="flex flex-col items-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">EasyColoc</h1>
            <p class="text-sm text-gray-500 mt-1">Gérez vos dépenses sans stress</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                <input
                    id="email" name="email" type="email"
                    value="{{ old('email') }}"
                    required autofocus
                    placeholder="nom@exemple.com"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white/80 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                >
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
            </div>

            {{-- Password --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="text-sm font-medium text-gray-700">Mot de passe</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 transition">
                            Oublié ?
                        </a>
                    @endif
                </div>
                <input
                    id="password" name="password" type="password"
                    required
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white/80 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                >
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-500" />
            </div>

            {{-- Remember me --}}
            <div class="flex items-center gap-2">
                <input id="remember_me" name="remember" type="checkbox"
                       class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="remember_me" class="text-sm text-gray-600 cursor-pointer">Se souvenir de moi</label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Se connecter
            </button>
        </form>

        <div class="mt-7 text-center text-sm text-gray-500">
            Nouveau dans la coloc ?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition">Créer un compte</a>
        </div>
    </div>
</x-guest-layout>