@php

$post_comments = \App\Helper\Helper::postComment($data->id)

@endphp

@extends('custom-layout.app')

@section('title', $data->first_name.' '.$data->last_name)

@section('content')
    <main
        class="container max-w-xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
        <!-- Newsfeed -->
        <section
            id="newsfeed"
            class="space-y-6">
            <!-- Barta Card -->
                <article
                    class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
                    <!-- Barta Card Top -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Avatar -->
                                <div class="flex-shrink-0">
                                    <img
                                        class="h-10 w-10 rounded-full object-cover"
                                        src="https://avatars.githubusercontent.com/u/61485238"
                                        alt="Al Nahian" />
                                </div>
                                <!-- /User Avatar -->

                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <a
                                        href="{{route('profile',$data->username)}}"
                                        class="hover:underline font-semibold line-clamp-1">
                                        {{$data->first_name .' '.$data->last_name}}
                                    </a>
                                    <a
                                        href="{{route('profile',$data->username)}}"
                                        class="hover:underline text-sm text-gray-500 line-clamp-1">
                                        {{'@'.$data->username}}
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

                                    @if(\Auth::user()->id == $data->user_id)
                                        <!-- Dropdown menu -->
                                        <div
                                            x-show="open"
                                            @click.away="open = false"
                                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                            role="menu"
                                            aria-orientation="vertical"
                                            aria-labelledby="user-menu-button"
                                            tabindex="-1">
                                            <a
                                                href="{{route('post.edit',$data->uuid)}}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                role="menuitem"
                                                tabindex="-1"
                                                id="user-menu-item-0"
                                            >Edit</a
                                            >
                                            <form id="delete-single-post-form-{{ $data->id }}" action="{{ route('post.delete', $data->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1" onclick="confirmPostDelete({{ $data->id }})">Delete</a>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <!-- /Card Action Dropdown -->
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="py-4 text-gray-700 font-normal">
                        <p>{{$data->description ?? ''}}</p>
                    </div>
                    <!-- Date Created & View Stat -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs my-2">

                        <span class="">
                           {{\App\Helper\Helper::postCreateTime($data->post_created_at)}}
                        </span>
                        <span class=""></span>
                        <span> {{$data->view_count}} views</span>
                    </div>

                    <!-- Barta Card Bottom -->
                    <footer class="border-t border-gray-200 pt-2">
                        <!-- Card Bottom Action Buttons -->
                        <div class="flex items-center justify-between">
                            <div class="flex gap-8 text-gray-600">
                                <!-- Heart Button -->
                                <button
                                    type="button"
                                    data-id = "{{$data->id}}"
                                    data-user_id = "{{Auth::id()}}"
{{--                                    data-react-count="{{$react_count ?? 0}}"--}}
                                    class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 react">
                                    <span class="sr-only">Like</span>
                                    @php
                                        $react_check = \App\Helper\Helper::reactCheck($data->id);
                                        $react_count = \App\Helper\Helper::reactCount($data->id);
                                    @endphp
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="{{isset($react_check->react_yn) && $react_check->react_yn  === "Y" ? 'currentColor': 'none'}}"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-5 h-5 react-svg-{{$data->id}}"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>

                                    <p class="react_count">{{$react_count ?? '0'}}</p>
                                </button>
                                <!-- /Heart Button -->

                                <!-- Comment Button -->
                                <button
                                    type="button"
                                    class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
                                    <span class="sr-only">Comment</span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                                    </svg>

                                    <p>{{count($post_comments)}}</p>
                                </button>
                                <!-- /Comment Button -->
                            </div>

                            <div>
                                <!-- Share Button -->
                                <button
                                    type="button"
                                    class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
                                    <span class="sr-only">Share</span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                                    </svg>
                                </button>
                                <!-- /Share Button -->
                            </div>
                        </div>

                        <!-- /Card Bottom Action Buttons -->
                    </footer>
                    <form action="{{route('comment.store')}}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$data->id}}">
                        <input type="hidden" name="comment_id" value="{{$user_comment->id ?? null}}">
                        <!-- Create Comment Card Top -->
                        <div>
                            <div class="flex items-start /space-x-3/">
                                <!-- User Avatar -->
                                <!-- <div class="flex-shrink-0">-->
                                <!--              <img-->
                                <!--                class="h-10 w-10 rounded-full object-cover"-->
                                <!--                src="https://avatars.githubusercontent.com/u/831997"-->
                                <!--                alt="Ahmed Shamim" />-->
                                <!--            </div> -->
                                <!-- /User Avatar -->

                                <!-- Auto Resizing Comment Box -->
                                <div class="text-gray-700 font-normal w-full">

                  <textarea x-data="{
                          resize () {
                              $el.style.height = '0px';
                              $el.style.height = $el.scrollHeight + 'px'
                          }
                      }" x-init="resize()" @input="resize()" type="text" name="comment" placeholder="Write a comment..." class="flex w-full h-auto min-h-[40px] px-3 py-2 text-sm bg-gray-100 focus:bg-white border border-sm rounded-lg border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900" style="height: 38px;">{{$user_comment->comment ?? ''}}</textarea>
                                </div>
                            </div>
                        </div>


                        <!-- Create Comment Card Bottom -->
                        <div>
                            <!-- Card Bottom Action Buttons -->
                            <div class="flex items-center justify-end">
                                <button type="submit" class="mt-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                                    Comment
                                </button>
                            </div>
                            <!-- /Card Bottom Action Buttons -->
                        </div>
                        <!-- /Create Comment Card Bottom -->
                    </form>
                    <!-- /Barta Card Bottom -->
                </article>
            <!-- /Barta Card -->
        </section>

{{--@dd($data)--}}
        <section id="newsfeed" class="space-y-6">

            <hr>
            <div class="flex flex-col space-y-6">
                <h1 class="text-lg font-semibold">Comments ({{ count($post_comments) }})</h1>

                <!-- Barta User Comments Container -->
                @if(filled($post_comments))
                <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-2 sm:px-6 min-w-full divide-y">
                    <!-- Comments -->

                    @foreach($post_comments as $comment)
                        <div class="py-4">
                            <!-- Barta User Comments Top -->
                            <header>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <!-- User Info -->
                                        <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                            <a  href="{{route('profile',$comment->username)}}" class="hover:underline font-semibold line-clamp-1">
                                                {{$comment->first_name.' '.$comment->last_name}}
                                            </a>

                                            <a  href="{{route('profile',$comment->username)}}" class="hover:underline text-sm text-gray-500 line-clamp-1">
                                                {{'@'.$comment->username}}
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
                                            @if(Auth::user()->id  == $comment->user_id)
                                            <!-- Dropdown menu -->
                                            <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
                                                <a href="{{route('comment.edit',[$comment->post_id,$comment->id])}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Edit</a>
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
                            <div class="py-4 text-gray-700 font-normal">
                                <p>{{$comment->comment ?? ''}}</p>
                            </div>

                            <!-- Date Created -->
                            <div class="flex items-center gap-2 text-gray-500 text-xs">
                                <span class="">{{\App\Helper\Helper::commentCreateTime($comment->comment_created_at)}}</span>
                            </div>
                        </div>
                    @endforeach
                    <!-- /Comments -->
                </article>
                @endif
                <!-- /Barta User Comments -->
            </div>
        </section>
        <!-- /Newsfeed -->
    </main>
@endsection


@section('script')

    <script>
        function confirmPostDelete(id) {
            if (confirm('Are you sure you want to remove the post?')) {
                document.getElementById('delete-single-post-form-' + id).submit();
            }
        }
        function confirmCommentDelete(id) {
            if (confirm('Are you sure you want to remove the comment?')) {
                document.getElementById('delete-comment-form-' + id).submit();
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
