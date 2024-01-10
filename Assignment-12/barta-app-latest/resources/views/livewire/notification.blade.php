<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="relative ml-3"
         x-data="{ open: false }">
        <button @click="open = !open" type="button" class="relative rounded-full bg-white p-2 text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <span class="sr-only">View notifications</span>
            <!-- Heroicon name: outline/bell -->
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
            <!-- Badge -->
            <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2">{{count($notifications)}}</div>
        </button>
        <div
            x-show="open"
            @click.away="open = false"
            class="absolute left-1/2 transform -translate-x-1/2 z-10 mt-2 w-80 origin-top-right rounded-md bg-white p-2 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="user-menu-button"
            tabindex="-1">

            @foreach($notifications->take(5) as $notification)
                <div class="flex items-center space-x-3 hover:bg-gray-200 rounded-lg p-2">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        <a href="#">
                            @if(isset($notification->data['user_image']))
                                <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    src="{{ $notification->data['user_image'] }}"
                                    alt="profile image"/>
                            @else
                                <svg
                                    class="h-12 w-12 text-gray-300"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    aria-hidden="true">
                                    <!-- Your default image/svg here -->
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
                            id="user-menu-item-0"
                        >
                            {{ $notification->data['full_name']  ?? 'X'}} {{ isset($notification->data['message']) && $notification->data['message'] == 'like_for_post' ? 'Likes':'Commented' }} on your post.
                        </a>
                    </div>
                    <!-- /User Info -->
                </div>
        @endforeach

        <!-- See All Link -->
                <div class="text-gray-900 text-center mt-1 bg-gray-200 rounded-lg p-2 flex flex-col min-w-0 flex-1">
                    <a
                        href="{{route('notifications.index')}}"
                        class="block p-1 text-sm rounded-lg text-gray-700"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >See All Notification</a>
                </div>
        </div>
    </div>
</div>
