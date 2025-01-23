<x-guest-layout>
    {{-- <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card> --}}
    <div class="font-[sans-serif]">
        <div class="min-h-screen flex fle-col items-center justify-center py-6 px-4">
            <div class="grid md:grid-cols-2 items-center gap-6 max-w-6xl w-full">
                <div
                    class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <x-validation-errors class="mb-4" />
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-bold">Sign in</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed">Sign in to your account and explore a
                                world of possibilities.</p>
                        </div>

                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Email</label>
                            <div class="relative flex items-center">
                                <input id="email" type="text" type="email" name="email"
                                    :value="old('email')" required autofocus autocomplete="username"
                                    class="w-full text-sm text-gray-800 border border-gray-300 pl-4 pr-10 py-3 rounded-lg outline-blue-600"
                                    placeholder="Enter your email" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] absolute right-4 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input id="password" type="password" name="password" required
                                    autocomplete="current-password"
                                    class="w-full text-sm text-gray-800 border border-gray-300 pl-4 pr-10 py-3 rounded-lg outline-blue-600"
                                    placeholder="Enter password" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] absolute right-4 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember_me" name="remember"
                                    class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                                <label for="remember_me" class="ml-3 block text-sm text-gray-800">
                                    Remember me
                                </label>
                            </div>

                            <div class="text-sm">
                                <a href="{{ route('password.request') }}"
                                    class="text-blue-600 hover:underline font-semibold">
                                    Forgot your password?
                                </a>
                            </div>
                        </div>

                        <div class="!mt-8">
                            <button type="submit" id="submitButton"
                                class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none flex items-center justify-center">
                                <span id="buttonText">Sign in</span>
                                <svg id="buttonSpinner" class="animate-spin ml-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>

                        {{-- <p class="text-sm !mt-8 text-center text-gray-500">Don't have an account <a
                                href="{{ route('register') }}"
                                class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Register
                                here</a></p> --}}
                    </form>
                </div>
                <div class="max-md:mt-8">
                    <img src="https://readymadeui.com/login-image.webp"
                        class="w-full aspect-[71/50] max-md:w-4/5 mx-auto block object-cover" alt="Dining Experience" />
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                const submitButton = document.getElementById('submitButton');
                const buttonText = document.getElementById('buttonText');
                const buttonSpinner = document.getElementById('buttonSpinner');

                form.addEventListener('submit', function() {
                    submitButton.disabled = true;
                    buttonText.textContent = 'Loading';
                    buttonSpinner.classList.remove('hidden');
                });
            });
        </script>
    @endpush
</x-guest-layout>
