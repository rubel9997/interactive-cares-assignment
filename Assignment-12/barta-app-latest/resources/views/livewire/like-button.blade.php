<div>
    {{-- Stop trying to control. --}}
    <button wire:click="toggleLike()"
        type="button"
        class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 react">
        <span class="sr-only">Like</span>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill=" {{ (\Illuminate\Support\Facades\Auth::user()->hasLiked($post)) ? 'currentColor':'none' }}"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-5 h-5 {{ (\Illuminate\Support\Facades\Auth::user()->hasLiked($post)) ? 'text-red-600':'text-gray-600' }}"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
        </svg>

        <p class="like_count">{{$post->likes()->count()}}</p>
    </button>
</div>
