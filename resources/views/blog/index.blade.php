<x-app-layout>
    <div class="flex flex-col p-4">
        <div class="flex justify-end pb-2">
            <a href="{{ url('blog/create') }}"
               type="button"
               class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                {{ trans('blog.btn.create') }}
            </a>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left">
                <thead class="text-white">
                    <tr class="bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                        <th class="px-3 py-3">{{ trans('blog.table.title') }}</th>
                        <th class="px-3 py-3">{{ trans('blog.table.message') }}</th>
                        <th class="px-3 py-3">{{ trans('blog.table.authors') }}</th>
                        <th class="px-3 py-3">{{ trans('blog.table.dateTime') }}</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach(json_decode($blog) as $row)
                        <tr class="bg-white border-b">
                            <td class="px-3 py-1">
                                <div class="w-56 m-2 truncate">
                                    <a
                                        href='{{ url("blog/{$row->id}") }}'
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    >
                                        {{ $row->title }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-3 py-1">
                                <div class="w-96 m-2 truncate">
                                    {{ $row->message }}
                                </div>
                            </td>
                            <td class="px-3 py-1">{{ $row->userName }}</td>
                            <td class="px-3 py-1">{{ $row->created_at }}</td>
                            <td class="flex space-x-1 my-2">
                                @if(Auth::user()->id === $row->user_id)
                                    <a href='{{ url("blog/{$row->id}/edit") }}'
                                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
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

                                    <x-secondary-button
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                    >
                                        <svg
                                            class="text-red-500"
                                            width="24"
                                            height="24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            fill="none"
                                        >
                                            <path stroke="none" d="M0 0h24v24H0z"/>
                                            <line x1="4" y1="7" x2="20" y2="7" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </x-secondary-button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
