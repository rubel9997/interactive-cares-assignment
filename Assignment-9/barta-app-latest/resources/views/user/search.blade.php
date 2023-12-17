
@extends('custom-layout.app')

@section('title','Search People')

@section('content')
    <main
        class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
        <!-- Newsfeed -->
        <section
            id="newsfeed"
            class="space-y-6">
            <!-- Barta Card -->
            @if(filled($data))
            @foreach($data as $user)
                <article
                    class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
                    <!-- Barta Card Top -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Avatar -->
                                <div class="flex-shrink-0">
                                    <a href="{{route('profile',$user->username)}}">
                                        @if($user->getFirstMediaUrl())
                                            <img
                                                class="h-10 w-10 rounded-full object-cover"
                                                src="{{$user->getFirstMediaUrl()}}"
                                                alt="profile image" />
                                        @else
                                            <svg
                                                class="h-12 w-12 text-gray-300"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                aria-hidden="true">
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </a>
                                </div>
                                <!-- /User Avatar -->

                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <a
                                        href="{{route('profile',$user->username)}}"
                                        class="hover:underline font-semibold line-clamp-1">
                                        {{$user->first_name .' '.$user->last_name}}
                                    </a>
                                    <a
                                        href="{{route('profile',$user->username)}}"
                                        class="hover:underline text-sm text-gray-500 line-clamp-1">
                                        {{'@'.$user->username}}
                                    </a>
                                </div>
                                <!-- /User Info -->
                            </div>

                            <!-- Card Action Dropdown -->
                            <div class="flex flex-shrink-0 self-center" x-data="{ open: false }">
                                <div class="relative inline-block text-left">
                                    <div>
                                        <button
                                            @click="open = !open"
                                            type="button"
                                            class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                                            id="menu-0-button">
                                            <span class="sr-only">Open options</span>
                                            <svg
                                                class="h-5 w-5"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"></path>
                                            </svg>
                                        </button>
                                    </div>

{{--                                    @if(\Auth::user()->id == $user->id)--}}
{{--                                    <!-- Dropdown menu -->--}}
{{--                                        <div--}}
{{--                                            x-show="open"--}}
{{--                                            @click.away="open = false"--}}
{{--                                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"--}}
{{--                                            role="menu"--}}
{{--                                            aria-orientation="vertical"--}}
{{--                                            aria-labelledby="user-menu-button"--}}
{{--                                            tabindex="-1">--}}
{{--                                            <a--}}
{{--                                                href="{{route('post.edit',$user->uuid)}}"--}}
{{--                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"--}}
{{--                                                role="menuitem"--}}
{{--                                                tabindex="-1"--}}
{{--                                                id="user-menu-item-0"--}}
{{--                                            >Edit</a--}}
{{--                                            >--}}
{{--                                            <form id="delete-post-form-{{ $user->id }}" action="{{ route('post.delete', $user->id) }}" method="post">--}}
{{--                                                @csrf--}}
{{--                                                @method('delete')--}}
{{--                                                <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1" onclick="confirmDelete({{ $user->id }})">Delete</a>--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
                                </div>
                            </div>
                            <!-- /Card Action Dropdown -->
                        </div>
                    </header>
                    <!-- Content -->
{{--                    <div class="py-4 text-gray-700 font-normal space-y-2">--}}
{{--                        <a href="{{route('post.single',$post->uuid)}}">--}}
{{--                            <img src="{{ $post->getFirstMediaUrl() }}" class="min-h-auto w-full rounded-lg object-cover max-h-64 md:max-h-72" alt="">--}}
{{--                            <p class="mt-2">{{$post->description ?? ''}}</p>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <!-- Date Created & View Stat -->--}}
{{--                    <div class="flex items-center gap-2 text-gray-500 text-xs my-2">--}}

{{--                        <span class="">--}}
{{--                           {{\App\Helper\Helper::postCreateTime($post->created_at)}}--}}
{{--                        </span>--}}
{{--                        <span class=""></span>--}}
{{--                        <span>  {{count($post->viewCounts)}} views</span>--}}
{{--                    </div>--}}

{{--                    <!-- Barta Card Bottom -->--}}
{{--                    <footer class="border-t border-gray-200 pt-2">--}}
{{--                        <!-- Card Bottom Action Buttons -->--}}
{{--                        <div class="flex items-center justify-between">--}}
{{--                            <div class="flex gap-8 text-gray-600">--}}
{{--                            @php--}}
{{--                                $react_check = \App\Helper\Helper::reactCheck($post->id);--}}
{{--                            @endphp--}}
{{--                            <!-- Heart Button -->--}}
{{--                                <button--}}
{{--                                    type="button"--}}
{{--                                    data-id = "{{$post->id}}"--}}
{{--                                    data-user_id = "{{Auth::id()}}"--}}
{{--                                    class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 react">--}}
{{--                                    <span class="sr-only">Like</span>--}}
{{--                                    <svg--}}
{{--                                        xmlns="http://www.w3.org/2000/svg"--}}
{{--                                        fill="{{isset($react_check->react_yn) && $react_check->react_yn  === "Y" ? 'currentColor': 'none'}}"--}}
{{--                                        viewBox="0 0 24 24"--}}
{{--                                        stroke-width="2"--}}
{{--                                        stroke="currentColor"--}}
{{--                                        class="w-5 h-5 react-svg-{{$post->id}}"--}}
{{--                                    >--}}
{{--                                        <path--}}
{{--                                            stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round"--}}
{{--                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />--}}
{{--                                    </svg>--}}

{{--                                    <p class="react_count">{{count($post->reactCounts) ?? '0'}}</p>--}}
{{--                                </button>--}}
{{--                                <!-- /Heart Button -->--}}

{{--                                <!-- Comment Button -->--}}
{{--                                <button--}}
{{--                                    type="button"--}}
{{--                                    class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">--}}
{{--                                    <span class="sr-only">Comment</span>--}}
{{--                                    <svg--}}
{{--                                        xmlns="http://www.w3.org/2000/svg"--}}
{{--                                        fill="none"--}}
{{--                                        viewBox="0 0 24 24"--}}
{{--                                        stroke-width="2"--}}
{{--                                        stroke="currentColor"--}}
{{--                                        class="w-5 h-5">--}}
{{--                                        <path--}}
{{--                                            stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round"--}}
{{--                                            d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />--}}
{{--                                    </svg>--}}
{{--                                    <p>{{ count($post->comments) }} </p>--}}
{{--                                </button>--}}
{{--                                <!-- /Comment Button -->--}}
{{--                            </div>--}}

{{--                            <div>--}}
{{--                                <!-- Share Button -->--}}
{{--                                <button--}}
{{--                                    type="button"--}}
{{--                                    class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">--}}
{{--                                    <span class="sr-only">Share</span>--}}
{{--                                    <svg--}}
{{--                                        xmlns="http://www.w3.org/2000/svg"--}}
{{--                                        fill="none"--}}
{{--                                        viewBox="0 0 24 24"--}}
{{--                                        stroke-width="1.5"--}}
{{--                                        stroke="currentColor"--}}
{{--                                        class="w-5 h-5">--}}
{{--                                        <path--}}
{{--                                            stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round"--}}
{{--                                            d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
{{--                                <!-- /Share Button -->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- /Card Bottom Action Buttons -->--}}
{{--                    </footer>--}}
                    <!-- /Barta Card Bottom -->
                </article>
        @endforeach
            @else
        <!-- /Barta Card -->
            <div class="">
                <img src="{{asset('assets/logo/404.png')}}" alt="">
            </div>
            @endif
        </section>
        <!-- /Newsfeed -->
    </main>
@endsection
