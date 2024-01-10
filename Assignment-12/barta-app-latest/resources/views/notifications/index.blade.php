
@extends('custom-layout.app')

@section('title','Home')

@section('content')
    <main
        class="container max-w-xl mx-auto space-y-8 mt-6 w-full px-2 md:px-0 min-h-screen bg-white p-2 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        @foreach($notifications as $notification)
            <div class="flex items-center space-x-3 hover:bg-gray-200 p-3 m-2 rounded-lg">
                <!-- User Avatar -->
                <div class="flex-shrink-0">
                    <a  href="{{ isset($notification->data['link']) ? $notification->data['link'] : '#' }}">
                        @if(isset($notification->data['user_image']))
                            <img
                                class="h-10 w-10 rounded-full object-cover"
                                src="{{$notification->data['user_image']}}"
                                alt="profile image"/>
                        @else
                            <svg
                                class="h-12 w-12 text-gray-300"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                aria-hidden="true">
                                <path
                                    fill-rule="evenodd"
                                    d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                    clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </a>
                </div>
                <!-- /User Avatar -->

                <!-- User Info -->
                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                    <a
                        href="{{ isset($notification->data['link']) ? $notification->data['link'] : '#' }}"
                        class="block p-1 text-sm rounded-lg text-gray-700"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0">
                        {{ $notification->data['full_name']  ?? 'X'}} {{ isset($notification->data['message']) && $notification->data['message'] == 'like_for_post' ? 'Likes':'Commented' }} on your post.
                    </a>
                </div>
                <!-- /User Info -->
            </div>
        @endforeach
    </main>
@endsection
