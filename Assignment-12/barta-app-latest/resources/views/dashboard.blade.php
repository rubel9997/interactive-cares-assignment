
@extends('custom-layout.app')

@section('title','Home')

@section('content')
    <main
        class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
        <!-- Barta Create Post Card -->

        <form
            action="{{route('post.store')}}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white border-2 border-black rounded-lg  shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">
            <!-- Create Post Card Top -->
            @csrf
            <div>
                <div class="flex items-start /space-x-3/">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        @if($auth_user->getFirstMediaUrl())
                            <img
                                class="h-10 w-10 rounded-full object-cover"
                                src="{{$auth_user->getFirstMediaUrl()}}"
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
                    </div>
                    <!-- /User Avatar -->

                    <!-- Content -->
                    <div class="text-gray-700 font-normal w-full">
              <textarea
                  class="block w-full p-2 pt-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
                  name="description"
                  rows="2"
                  required
                  placeholder="What's going on, {{ $auth_user->first_name }}?"></textarea>
                    </div>
                </div>
            </div>

            <!-- Create Post Card Bottom -->
            <div>
                <!-- Card Bottom Action Buttons -->
                <div class="flex items-center justify-between">
                    <div class="flex gap-4 text-gray-600">
                        <!-- Upload Picture Button -->
                        <div>
                            <input
                                type="file"
                                name="picture"
                                id="picture"
                                class="hidden" />

                            <label
                                for="picture"
                                class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 cursor-pointer">
                                <span class="sr-only">Picture</span>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </label>
                        </div>
                        <!-- /Upload Picture Button -->

                        <!-- GIF Button -->
                        <button
                            type="button"
                            class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
                            <span class="sr-only">GIF</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12.75 8.25v7.5m6-7.5h-3V12m0 0v3.75m0-3.75H18M9.75 9.348c-1.03-1.464-2.698-1.464-3.728 0-1.03 1.465-1.03 3.84 0 5.304 1.03 1.464 2.699 1.464 3.728 0V12h-1.5M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                        </button>
                        <!-- /GIF Button -->

                        <!-- Emoji Button -->
                        <button
                            type="button"
                            class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
                            <span class="sr-only">Emoji</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                            </svg>
                        </button>
                        <!-- /Emoji Button -->
                    </div>

                    <div>
                        <!-- Post Button -->
                        <button
                            type="submit"
                            class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                            Post
                        </button>
                        <!-- /Post Button -->
                    </div>
                </div>
                <!-- /Card Bottom Action Buttons -->
            </div>
            <!-- /Create Post Card Bottom -->
        </form>
        <!-- /Barta Create Post Card -->

        <!-- Newsfeed -->
        <livewire:post/>
        <!-- /Newsfeed -->
    </main>
@endsection
@section('script')
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to remove the post?')) {
                document.getElementById('delete-post-form-' + id).submit();
            }
        }
    </script>
    <script>
        $(document).ready(function (){
            $('.react').on('click',function (e){
                e.preventDefault();

                let post_id = $(this).data('id');
                let user_id = $(this).data('user_id');
                const reactCountElement = $(this).find('.react_count');
                const svgElement = $('.react-svg-' + post_id);

                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url:'{{route('post.react')}}',
                    method:'POST',
                    data:{post_id:post_id,user_id:user_id},
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success:function (response){
                        // console.log(response);
                        if (response.react.react_yn === 'Y') {
                            svgElement.attr('fill', 'currentColor');
                            incrementCount(reactCountElement);
                        } else {
                            svgElement.attr('fill', 'none');
                            decrementCount(reactCountElement);
                        }
                    },
                    error:function (){

                    }
                })
            })

            // Function to increment the count
            function incrementCount(element) {
                let count = parseInt(element.text());
                count++;
                element.text(count);
            }

            // Function to decrement the count
            function decrementCount(element) {
                let count = parseInt(element.text());
                if (count > 0) {
                    count--;
                }
                element.text(count);
            }
        })
    </script>
@endsection
