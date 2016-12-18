@extends('layout.main')

@section('title', $heading)


@section('content')
    @if($accessories)
        <h3>Велокомпьютеры</h3>
        <ul>
            @foreach($accessories as $accessory)
                @if($accessory->accessory_id == 1)
                    <li><a href="/accessories/{{ $accessory->id }}">{{ $accessory->brand }}</a></li>
                @endif
            @endforeach
        </ul>

        <h3>Световые приборы</h3>
        <ul>
            @foreach($accessories as $accessory)
                @if($accessory->accessory_id == 2)
                    <li><a href="/accessories/{{ $accessory->id }}">{{ $accessory->brand }}</a></li>
                @endif
            @endforeach
        </ul>

        <h3>Разное</h3>
        <ul>
            @foreach($accessories as $accessory)
                @if($accessory->accessory_id == 3)
                    <li><a href="/accessories/{{ $accessory->id }}">{{ $accessory->brand }}</a></li>
                @endif
            @endforeach
        </ul>

    @else
        <p>No Accessories Found</p>
    @endif
        Содержимое страницы
@stop
