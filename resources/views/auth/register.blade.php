<x-guest-layout>

    <!-- background -->
    <div class="min-h-screen flex items-center justify-center bg-[#020617] relative overflow-hidden px-4">

        <!-- blur kiri atas -->
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-purple-700 rounded-full blur-3xl opacity-70"></div>

        <!-- blur kanan bawah -->
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-800 rounded-full blur-3xl opacity-70"></div>

        <!-- card -->
        <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/10 shadow-2xl">

            <!-- title -->
            <h1 class="text-4xl font-bold text-white text-center mb-2">
                CREATE ACCOUNT
            </h1>

            <!-- subtitle -->
            <p class="text-center text-gray-300 text-sm mb-8">
                Join us and start learning
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label
                        for="name"
                        :value="__('Full Name')"
                        class="text-white"
                    />

                    <x-text-input
                        id="name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <x-input-error
                        :messages="$errors->get('name')"
                        class="mt-2"
                    />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
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
                        autocomplete="new-password"
                    />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label
                        for="password_confirmation"
                        :value="__('Confirm Password')"
                        class="text-white"
                    />

                    <x-text-input
                        id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <x-input-error
                        :messages="$errors->get('password_confirmation')"
                        class="mt-2"
                    />
                </div>

                <!-- Button -->
                <div class="flex items-center justify-between mt-6">

                    <a
                        class="text-sm text-gray-300 hover:text-white transition"
                        href="{{ route('login') }}"
                    >
                        {{ __('Already have an account?') }}
                    </a>

                    <x-primary-button>
                        {{ __('Register') }}
                    </x-primary-button>

                </div>

            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-300">
                    {{ __('Already have an account?') }}
                    <a
                        href="{{ route('login') }}"
                        class="text-purple-400 hover:text-purple-300 transition font-semibold"
                    >
                        {{ __('Log in here') }}
                    </a>
                </p>
            </div>

        </div>

    </div>

</x-guest-layout>
