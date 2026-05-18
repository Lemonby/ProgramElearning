<x-guest-layout>

    <!-- background -->
    <div class="min-h-screen flex items-center justify-center bg-[#020617] relative overflow-hidden px-4">

        <!-- blur kiri -->
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-purple-700 rounded-full blur-3xl opacity-70"></div>

        <!-- blur kanan -->
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-800 rounded-full blur-3xl opacity-70"></div>

        <!-- card -->
        <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/10 shadow-2xl">

            <!-- title -->
            <h1 class="text-4xl font-bold text-white text-center mb-8">
                WELCOME
            </h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label
                        for="email"
                        :value="__('Email')"
                        class="text-white"
                    />

                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"
                    />
                </div>

                <!-- Password -->
                <div class="mt-4">

                    <x-input-label
                        for="password"
                        :value="__('Password')"
                        class="text-white"
                    />

                    <x-text-input
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />

                </div>

                <!-- Remember Me -->
                <div class="block mt-4">

                    <label for="remember_me" class="inline-flex items-center">

                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember"
                        >

                        <span class="ms-2 text-sm text-gray-300">
                            {{ __('Remember me') }}
                        </span>

                    </label>

                </div>

                <!-- Button -->
                <div class="flex items-center justify-end mt-4">

                    @if (Route::has('password.request'))
                        <a
                            class="underline text-sm text-gray-300 hover:text-white"
                            href="{{ route('password.request') }}"
                        >
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</x-guest-layout>
