<x-guest-layout>
    <!-- Session Status -->
    <div class="m-0 p-0 border-rounded-md flex flex-col items-center">
        <x-heroicon-o-user class="h-20 text-gray-500" />
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 ">
            Iniciar sesión
        </h2>
    </div>

    <form method="POST" action="{{ route('login') }}" class="form-login">
        @csrf

        <!-- Email Address -->

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required autofocus autocomplete="username" />

            <label for="email" class="block mt-1 w-full">
                @error('email')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <input type="password" id="password" class="block mt-1 w-full"
                name="password"
                required autocomplete="current-password" />

            <label for="password" class="block mt-1 w-full">
                @error('password')
                <span class="error">{{ $message }}</span>
                @enderror
            </label>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end flex-col mt-4 gap-2">

            <x-primary-button class="mx-auto mb-4">
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('register'))
            <a class="underline  text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                {{ __('Do not have an account? Register') }}
            </a>
            @endif
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif
        </div>
    </form>
</x-guest-layout>