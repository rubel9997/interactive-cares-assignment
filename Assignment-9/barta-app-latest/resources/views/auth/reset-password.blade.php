@extends('auth.layout.app')

@section('title','Forgot Password')

@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a
                href="javascript:void(0)"
                class="text-center text-6xl font-bold text-gray-900"
            ><h1>Barta</h1></a>
        </div>

        <div class="mt-15 sm:mx-auto sm:w-full sm:max-w-sm">
            <form
                class="space-y-6"
                action="{{route('password.store')}}"
                method="POST">
                @csrf
                     <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                    <label
                        for="email"
                        class="block text-sm font-medium leading-6 text-gray-900"
                    >Email address</label
                    >
                    <div class="mt-2">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            placeholder="bruce@wayne.com"
                            required
                            value="{{ old('email',$request->email) }}"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    @error('email')
                        <span class="mt-1 text-red-700 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            required
                            value="{{ old('password') }}"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    @error('password')
                        <span class="mt-1 text-red-700 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                    </div>
                    <div class="mt-2">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            required
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    @error('confirm_password')
                        <span class="mt-1 text-red-700 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                        Reset Password
                    </button>
                </div>
            </form>
            <p class="mt-10 text-center text-sm text-gray-500">
                Already a member?
                <a
                    href="{{route('login')}}"
                    class="font-semibold leading-6 text-black hover:text-black"
                >Sign In</a
                >
            </p>
        </div>
    </div>
@endsection
