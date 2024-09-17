<x-app-layout>
    <div class="max-w-6xl mx-auto p-4">
        <div class="mb-2">
            <label class="text-right text-base text-gray-500 dark:text-gray-400 block">
                <b>{{ __('blog.table.authors') }}: {{ $data['userName'] }}</b> {{ $data['created_at'] }}
            </label>
        </div>

        <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
            {{ $data['title'] }}
        </h1>

        <p class="text-justify">{{ $data['message'] }}</p>

        <form method="post" action='{{ url("comment/{$data['id']}") }}' class="py-4">
            @csrf

            <x-textarea
                id="message"
                class="block mt-1 w-full"
                type="text"
                name="message"
                :value="old('message')"
                required
                placeholder="{{ __('blog.comment.placeholder') }}"
            />
            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ trans('blog.btn.addComment') }}
                </x-primary-button>
            </div>
        </form>

        @foreach($data['comment'] as $row)
            <div class="block">
                <div class="flex items-center justify-between  font-medium">
                    <labrl class="text-left text-base text-gray-500 dark:text-gray-400 block">
                        <b>{{ $row['userName'] }}</b> {{ $row['created'] }}
                    </labrl>

                    @if(Auth::user()->id === $row['user_id'])
                        <div class="flex space-x-1 my-2">
                            <x-secondary-button onclick="toggleModal('{{ $row['id'] }}')">
                                <svg
                                    class="text-red-500"
                                    width="22"
                                    height="22"
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

                <p class="text-gray-500 leading-6 mb-10 line-clamp-5">
                    {{ $row['message'] }}
                </p>
            </div>
        @endforeach
    </div>

    <div
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
        id="modal-destroy"
        tabindex="-1" aria-hidden="true"
    >
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <form method="post" action='{{ url("comment/destroy") }}' class="relative p-6 flex-auto">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('blog.comment.destroy-msg') }}
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
