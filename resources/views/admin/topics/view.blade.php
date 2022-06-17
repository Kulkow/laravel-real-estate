<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Topics View') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <i>{{ $topic->id }}</i> - {{ $topic->title }}
                    @if ($topic->author)
                        <div class="author">
                            <b>{{ $topic->author->email}}</b> {{ $topic->author->name}}
                        </div>
                    @endif
                    @if ($topic->picture)
                        <div class="picture">
                            <img src="{{ $topic->picture->link()}}" alt="{{$topic->picture->title()}}" />
                        </div>
                    @endif
                    <div>
                        {{ $topic->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


