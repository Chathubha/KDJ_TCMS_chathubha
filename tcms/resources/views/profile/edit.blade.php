<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Profile</h2>
    </x-slot>

    <div class="max-w-2xl space-y-6">
        {{-- Profile Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900">Profile Information</h3>
                <p class="text-sm text-gray-500 mt-1">Update your account's profile information and email address.</p>
            </div>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required autofocus autocomplete="name">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" required autocomplete="username">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">
                                Your email address is unverified.
                                <button form="send-verification" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm">
                                    Click here to re-send the verification email.
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm text-emerald-600 font-medium">
                                    A new verification link has been sent to your email address.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm">Save</button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Saved.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900">Update Password</h3>
                <p class="text-sm text-gray-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                    <input type="password" name="current_password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" autocomplete="current-password">
                    @error('current_password', 'updatePassword') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                    <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" autocomplete="new-password">
                    @error('password', 'updatePassword') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" autocomplete="new-password">
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm">Save</button>
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Saved.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- Delete Account --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900">Delete Account</h3>
                <p class="text-sm text-gray-500 mt-1">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            </div>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-xl transition text-sm">Delete Account</button>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-bold text-gray-900">Are you sure you want to delete your account?</h2>
                    <p class="mt-2 text-sm text-gray-600">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>

                    <div class="mt-6">
                        <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none" placeholder="Password">
                        @error('userDeletion.password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" x-on:click="$dispatch('close')" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-3 px-6 rounded-xl transition">Cancel</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl transition">Delete Account</button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</x-app-layout>
