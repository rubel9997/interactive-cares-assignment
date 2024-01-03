
<div>
    @if($comment)
        <div class="my-2 text-gray-500 flex flex-col min-w-0 flex-1">
            <a  href="{{route('post.single',$comment->post->uuid)}}" class="hover:underline font-semibold line-clamp-1">
                View more comments
            </a>
        </div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
        <div class="p-2 rounded-md bg-gray-100">
            <!-- Barta User Comments Top -->
            <header>
                <div class="flex items-center justify-between">

                    <div class="flex items-center space-x-3">
                        <!-- User Avatar -->
                        <div class="flex-shrink-0">
                            <a href="{{route('profile',$comment->user->username)}}">
                                @if($comment->user->getFirstMediaUrl())
                                    <img
                                        class="h-10 w-10 rounded-full object-cover"
                                        src="{{$comment->user->getFirstMediaUrl()}}"
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
                            <a  href="{{route('profile',$comment->user->username)}}" class="hover:underline font-semibold line-clamp-1">
                                {{$comment->user->full_name}}
                            </a>
                        </div>
                        <!-- /User Info -->
                    </div>

                    <!-- Card Action Dropdown -->
                    <div class="flex flex-shrink-0 self-center" x-data="{ open: false }">
                        <div class="relative inline-block text-left">
                            <div>
                                <button @click="open = !open" type="button" class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600" id="menu-0-button">
                                    <span class="sr-only">Open options</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        {{--                                            @dd($comment)--}}
                        @if(Auth::user()->id  == $comment->user_id)
                            <!-- Dropdown menu -->
                                <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
                                    <a href="{{route('comment.edit',[$comment->post->uuid,$comment->uuid])}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Edit</a>
                                    <form id="delete-comment-form-{{ $comment->id }}" action="{{ route('comment.delete', $comment->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1" onclick="confirmCommentDelete({{ $comment->id }})">Delete</a>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /Card Action Dropdown -->
                </div>
            </header>

            <!-- Content -->
            <div class="text-gray-700 font-normal">
                <div class="py-1 text-gray-700 font-normal">
                    @if(strlen($comment->comment) <= 100)
                        <p class="commentText">{{ $comment->comment }}</p>
                    @else
                        <p class="commentText">{{ Illuminate\Support\Str::limit($comment->comment, 100) }} <a href="{{route('post.single',$comment->post->uuid)}}">See more</a></p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Date Created -->
        <div class="flex items-center gap-2 text-gray-500 text-xs mt-1">
            <span class="">{{$comment->created_at->diffForHumans()}}</span>
        </div>
    @endif
</div>

