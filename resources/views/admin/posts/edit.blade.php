<x-layout>
    <x-setting :heading="'Edit post: ' . $post->title">
        <form method="POST" action="/admin/posts/{{ $post->id }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <x-form.input name="title" :value="old('title', $post->title)"/>
            <x-form.input name="slug" :value="old('slug', $post->slug)"/>
            <div>
                <x-form.input name="thumbnail" type="file" :value="old('thumbnail', $post->thumbnail)"/>
                <img src="/storage/{{ $post->thumbnail }}" alt="" class="rounded-xl" width="100">
            </div>
            <x-form.textarea name="excerpt">{{ old('excerpt', $post->excerpt) }}</x-form.textarea>
            <x-form.textarea name="body">{{ old('body', $post->body) }}</x-form.textarea>
            <x-form.field >
                <x-form.label name="category_id"/>
                <select name="category_id" id="category_id">

                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ ucwords($category->name) }}</option>
                    @endforeach
                </select>
                <x-form.error name="category_id" />
            </x-form.field>
            <x-form.submit-button>Update</x-form.submit-button>
        </form>
    </x-setting>

</x-layout>
