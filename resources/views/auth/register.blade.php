<x-app-layout>
    <form
        action="{{ route('register') }}"
        method="post"
        class="w-[400px] mx-auto p-6 my-16"
    >
        @csrf
        <h2 class="text-2xl font-semibold text-center mb-4">Create an account</h2>
        <p class="text-center text-gray-500 mb-3">
            or
            <a
                href="{{ route('login') }}"
                class="text-sm text-purple-700 hover:text-purple-600"
            >login with existing account</a
            >
        </p>
        <div class="mb-4">
            <x-text-input
                placeholder="Your name"
                type="text"
                name="name"
                :value="old('name')"
                class="block mt-1 w-full"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        </p>
        <div class="mb-4">
            <x-text-input
                placeholder="Your Email"
                type="email"
                name="email"
                :value="old('email')"
                class="block mt-1 w-full"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-4">
            <x-text-input
                placeholder="Password"
                type="password"
                name="password"
                class="block mt-1 w-full"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        </div>
        <div class="mb-4">
            <x-text-input
                placeholder="Repeat Password"
                type="password"
                name="password_confirmation"
                class="block mt-1 w-full"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button
            class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full"
        >
            Signup
        </button>
    </form>
</x-app-layout>
