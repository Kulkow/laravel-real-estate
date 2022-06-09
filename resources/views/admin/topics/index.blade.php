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
            {{ __('Topics add') }}
        </a>
        @foreach ($topics as $topic)
            <div class="py-12">
                <div class="py-10">
                    <i>{{ $topic->id }}</i> - {{ $topic->title }} - {{ $topic->author_id }}
                </div>
                <div class="py-2">
                    <a href="{{ route('topic.view', ['id' => $topic->id]) }}">
                        {{ __('Topics view') }}
                    </a>
                </div>
            </div>
        @endforeach
                </div>
            </div>
        </div>
    </div>
    {{ $topics->links() }}
</x-app-layout>


