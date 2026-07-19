<x-guest-layout>
    <!-- Background wrapper-->
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 pt-6 sm:pt-0">
        
        <!-- Login Card -->
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl rounded-3xl border border-gray-100">
            
            <!-- Header Section -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-800">Masuk</h2>
                <p class="text-sm text-gray-500 mt-2">Grosir Sembako Management System</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" class="text-gray-700 font-semibold" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-2 w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@grosir.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" class="text-gray-700 font-semibold" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-2 w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-800 font-medium" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <x-primary-button class="w-full justify-center py-3 bg-blue-700 hover:bg-blue-800 rounded-lg transition duration-200 shadow-lg">
                    {{ __('Log in') }}
                </x-primary-button>
            </form>

            <!-- Footer Link -->
            <div class="text-center mt-8 border-t pt-6">
                <p class="text-sm text-gray-600">
                    Bukan staff? 
                    <a href="{{ route('konsumen.login') }}" class="text-blue-700 hover:text-blue-900 font-semibold underline">
                        Login sebagai Pelanggan
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>