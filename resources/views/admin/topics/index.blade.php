<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Topics') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('topic.add') }}">
                        {{ __('topic.Topics add') }}
                    </a>
                    <div id="app-topics">
                        <topic-table auth-token="1|bvvzC3ndTJkbpieCCI7unbZ9vLWOqzwvJomMt1Wl"></topic-table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/topics.js') }}" defer></script>
</x-app-layout>


