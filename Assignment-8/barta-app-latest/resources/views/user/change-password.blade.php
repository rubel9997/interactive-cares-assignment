@extends('custom-layout.app')

@section('title','Password Change')

@section('content')
    <main
        class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
        <!-- Profile Edit Form -->

        <form action="{{route('password.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="space-y-12">
                <div class=" border-gray-900/10 pb-12">
                    <h2 class="text-xl font-semibold leading-7 text-gray-900">
                       Password Change
                    </h2>
                    <div class="mt-10  border-gray-900/10 pb-12">

                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <div class="flex items-center justify-between">
                                    <label
                                        for="password"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                    >Current Password</label
                                    >
                                </div>
                                <div class="mt-2">
                                    <input
                                        type="password"
                                        name="current_password"
                                        id="current_password"
                                        autocomplete="password"
                                        required
                                        class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                                </div>
                                @error('current_password')
                                <span class="mt-1 text-red-700 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full">
                                <label
                                    for="new_password"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                >New Password</label
                                >
                                <div class="mt-2">
                                    <input
                                        type="password"
                                        name="new_password"
                                        id="new_password"
                                        autocomplete="password"
                                        required
                                        class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                                </div>
                                @error('new_password')
                                <span class="mt-1 text-red-700 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-full">
                                <label
                                    for="confirm_password"
                                    class="block text-sm font-medium leading-6 text-gray-900"
                                >Confirm Password</label
                                >
                                <div class="mt-2">
                                    <input
                                        type="password"
                                        name="confirm_password"
                                        id="confirm_password"
                                        autocomplete="password"
                                        required
                                        class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                                </div>
                                @error('confirm_password')
                                <span class="mt-1 text-red-700 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button
                    type="button"
                    class="text-sm font-semibold leading-6 text-gray-900">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                    update
                </button>
            </div>
        </form>
        <!-- /Profile Edit Form -->
    </main>
@endsection
