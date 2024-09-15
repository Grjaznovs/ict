<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet" />

<x-app-layout>
    <form method="post" action="{{ url("blog/{$blog->id}") }}" class="max-w-2xl mx-auto p-4">
        {{ method_field('PUT') }}
        @csrf

        <div class="mb-2">
            <x-input-label for="category" :value="trans('blog.categories.title')" />
            <select
                id="category"
                name="categoriesId[]"
                multiple
                required
                placeholder=""
                autocomplete="off"
                class="block w-full rounded-sm cursor-pointer"
            >
                @foreach($categories as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <x-input-label for="title" :value="trans('blog.table.title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" maxlength="100" value="{{ $blog->title }}" required autofocus autocomplete="title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="message" :value="trans('blog.table.message')" />
            <x-textarea id="message" class="block mt-1 w-full" type="text" name="message" required autofocus autocomplete="message">
                {{ $blog->message }}
            </x-textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ trans('blog.btn.save') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#category', {});
</script>
