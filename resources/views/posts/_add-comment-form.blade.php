@auth
    <x-panel>
        <form method="POST" action="/posts/{{ $post->slug }}/comments">
            @csrf
            <header class="flex items-center">
                <img src="https://i.pravatar.cc/60?u={{ $post->author->id }}" alt="" width="40" height="40" class="rounded-full">
                <h2 class="ml-4">Want to participate?</h2>
            </header>

            <div class="mt-6">
                <textarea
                                    name="body"
                                    class="w-full text-sm focus:outline-none focus:ring"
                                    rows="5"
                                    placeholder="Quick, say something funny!"
                                    required></textarea>

                @error('body')
                <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end mt-6 border-t border-gray-200 pt-6">
                <x-form.submit-button>Post</x-form.submit-button>
            </div>

        </form>
    </x-panel>
@else
    <p><a href="/login" class="hover:underline">Log in if you want to post</a> </p>
@endauth
@foreach ($post->comments as $comment)
    <x-post-comment :comment="$comment"/>
@endforeach
