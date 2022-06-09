<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Topics Edit') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('topic.edit', ['id' => $id]) }}">
                        @csrf
                        <!-- Title -->
                        <div>
                            <x-label for="title" :value="__('Title')"/>

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$topic->title"
                                     required autofocus/>
                        </div>
                        <!-- description Address -->
                        <div class="mt-4">
                            <x-label for="description" :value="__('description')"/>
                            <x-textarea id="description" class="block mt-1 w-full" name="description"
                                        :value="$topic->description" required/>
                        </div>
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


