@extends('Layouts.frontend')

@section('content')
    <div class="list-sp-home">
        <img class="title-list-sp" src="{{ URL::asset('images/title-nongnghiep.png')}}"/>
        <div class="cover-list-sp">
            @foreach($listNNHome as $item)
                <div class="item-sp">
                    <a class="a-cover-img" href="{{ URL::to('/nong-nghiep/'.$item->id.'/'.str_slug($item->name, '-')) }}"><img src="{{$item->thumb}}"/></a>
                    <div class="cv-img"><img class="img-cover-a" src="./images/bg-title-sp.png"/></div>
                    <a class="a-sp" href="{{ URL::to('/nong-nghiep/'.$item->id.'/'.str_slug($item->name, '-')) }}">{{$item->name}}</a>
                </div>
            @endforeach
        </div>
    </div>
@stop