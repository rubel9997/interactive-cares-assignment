@extends('auth.layout.app')

@section('title','Login')

@section('content')
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a
                href="javascript:void(0)"
                class="text-center text-6xl font-bold text-gray-900"
            ><h1>Barta</h1></a
            >

            <h1
                class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Sign in to your account
            </h1>
        </div>

        @if(Session::has('success'))
            <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
                <div class="bg-green-100 border border-red-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{Session::get('success')}}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
                </div>
            </div>
        @endif

        @if(Session::has('error'))
            <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{Session::get('error')}}</strong>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
                </div>
            </div>
        @endif

        <div class="mt-15 sm:mx-auto sm:w-full sm:max-w-sm">
            <form
                class="space-y-6"
                action="{{route('login')}}"
                method="POST">
                @csrf
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
                            value="{{ old('email') }}"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    @error('email')
                    <span class="mt-1 text-red-700 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm font-medium leading-6 text-gray-900"
                        >Password</label
                        >
                        <div class="text-sm">
                            <a
                                href="{{route('password.request')}}"
                                class="font-semibold text-black hover:text-black"
                            >Forgot password?</a
                            >
                        </div>
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
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Don't have an account yet?
                <a
                    href="{{route('register')}}"
                    class="font-semibold leading-6 text-black hover:text-black"
                >Sign Up</a
                >
            </p>
        </div>
    </div>
@endsection
