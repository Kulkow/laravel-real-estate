<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('topic.Topics Edit') }}
        </h2>
    </x-slot>
    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" enctype="multipart/form-data" action="{{ route('topic.update', ['id' => $id]) }}">
                        @csrf
                        <!-- Title -->
                        <div>
                            <x-label for="title" :value="__('topic.title')"/>
                            <x-input id="title" class="block mt-1 w-full @error('title') is-invalid @enderror" type="text" name="title" :value="$topic->title"
                                     />
                        </div>
                        <!-- description Address -->
                        <div class="mt-4">
                            <x-label for="description" :value="__('topic.description')"/>
                            <x-textarea id="description" class="block mt-1 w-full @error('description') is-invalid @enderror" name="description">
                                {{ $topic->description }}
                            </x-textarea>
                        </div>
                        <!-- Image -->
                        <div>
                            <x-label for="picture" :value="__('topic.picture')"/>
                            <x-input id="picture" class="block mt-1 w-full @error('picture') is-invalid @enderror" type="file" name="picture"
                            />
                        </div>
                        <input type="hidden" name="picture_id" value="{{$topic->picture_id}}" />
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Edit') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


