<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Graphic') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('statistic_task.add', ['id' => $employe->id]) }}"
                       class="p-1 rounded border-black border-2 mb-5 inline-block">
                        {{ __('Add') }}
                    </a>
                    <div class="mb-5 text-2xl">{{$employe->last_name}} - {{$employe->name}}</div>
                    @if(! empty($statistics['days']))
                        <div class="grid grid-cols-2">
                            @foreach ($statistics['days'] as $day => $stat)
                                <div class="item-day mb-5 pr-5">
                                    <p class="italic">{{$day}}</p>
                                    <div>
                                        @if($stat['complete'] >= $stat['plan'])
                                            <p class="bg-green-200">
                                                Было выполнено - {{$stat['complete']}} из {{$stat['plan']}}
                                            </p>
                                        @else
                                            <p class="bg-red-500">
                                                Было выполнено - {{$stat['complete']}} из {{$stat['plan']}}
                                            </p>
                                        @endif
                                        <div class="mb-2">
                                            @foreach ($stat['tasks']['plans'] as $key => $link)
                                                @if(! empty($stat['tasks']['completed']))
                                                    <p class="bg-green-500">{{$link}}</p>
                                                @else
                                                    <p class="bg-red-500">{{$link}}</p>
                                                @endif
                                            @endforeach
                                        </div>
                                        @if(! empty($stat['tasks']['not_completed']))
                                            <div class="mb-2">
                                                <div class="bg-red-500">
                                                    Не выполнены :
                                                </div>
                                                @foreach ($stat['tasks']['not_completed'] as $key => $link)
                                                    <p>{{$link}}</p>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if(! empty($stat['tasks']['not_plans']))
                                            <div class="mb-2">
                                                <div class="bg-green-500">
                                                    Не по плану :
                                                </div>
                                                @foreach ($stat['tasks']['not_plans'] as $key => $link)
                                                    <p>{{$link}}</p>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(! empty($statistics['duples']))
                        <div class="bg-red-500">Повторяющиему задачи: {{count($statistics['duples'])}}</div>
                        @foreach($statistics['duples'] as $duples)
                            <div>
                                <p><a href="{{$duples['link']}}" target="__blank" class="text-blue-900">{{$duples['link']}}</a></p>
                                @foreach($duples['days'] as $dupleDay)
                                    <span>{{$dupleDay}},</span>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>


