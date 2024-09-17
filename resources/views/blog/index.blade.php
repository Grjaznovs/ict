<x-app-layout>
    <div class="mx-auto max-w-6xl py-2">
        <form
            method="get"
            action="{{ url('blog') }}"
            class="flex items-center justify-between font-medium"
        >
            <div class="relative w-10/12">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input
                    name="search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="{{ trans('blog.blog.placeholder-search') }}"
                    value="{{ $search }}"
                />
                <button
                    type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    {{ trans('blog.btn.search') }}
                </button>
            </div>

            <div class="flex justify-end pb-2">
                <a href="{{ url('blog/create') }}"
                   type="button"
                   class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    {{ trans('blog.btn.create') }}
                </a>
            </div>
        </form>

        <div class="grid grid-cols-3 gap-4 py-4">
            @foreach(json_decode($blog) as $row)
                <div class="bg-white group cursor-pointer w-full max-lg:max-w-xl border border-gray-300 rounded-2xl p-5 transition-all duration-300 hover:border-indigo-600">
                    <div class="block">
                        <labrl class="text-right text-indigo-600 font-medium mb-3 block">
                            <b class="px-2">{{ $row->userName }}</b>{{ $row->created_at }}
                        </labrl>

                        <h4 class="text-xl text-gray-900 font-medium leading-8 mb-5">
                            {{ $row->title }}
                        </h4>

                        <p class="text-gray-500 leading-6 mb-10 line-clamp-5">
                            {{ $row->message }}
                        </p>

                        <div class="flex items-center justify-between  font-medium">
                            <a
                                href='{{ url("blog/{$row->id}") }}'
                                class="cursor-pointer text-lg text-indigo-600 font-semibold"
                            >
                                Read more..
                            </a>

                            @if(Auth::user()->id === $row->user_id)
                                <div class="flex space-x-1 my-2">
                                    <a href='{{ url("blog/{$row->id}/edit") }}'
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        <svg
                                            width="24"
                                            height="24"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1"
                                        >
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>

                                    <x-secondary-button onclick="toggleModal('{{ $row->id }}')">
                                        <svg
                                            class="text-red-500"
                                            width="24"
                                            height="24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                        >
                                            <line x1="4" y1="7" x2="20" y2="7" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </x-secondary-button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
        id="modal-destroy"
        tabindex="-1" aria-hidden="true"
    >
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <form method="post" action='{{ url("blog/destroy") }}' class="relative p-6 flex-auto">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('blog.blog.destroy-msg') }}
                    </h2>
                    <input hidden name="id" id="id" value="">

                    <div class="flex items-center justify-end p-4 border-t border-solid border-blueGray-200 rounded-b">
                        <x-secondary-button onclick="toggleModal('modal-destroy')">
                            {{ __('blog.btn.cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ms-3">
                            {{ __('blog.btn.delete') }}
                        </x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-destroy-backdrop"></div>
</x-app-layout>

<script type="text/javascript">
    function toggleModal(id) {
        document.getElementById('id').value = id;
        document.getElementById('modal-destroy').classList.toggle("hidden");
        document.getElementById('modal-destroy').classList.toggle("flex");
        document.getElementById("modal-destroy-backdrop").classList.toggle("hidden");
        document.getElementById("modal-destroy-backdrop").classList.toggle("flex");
    }
</script>
