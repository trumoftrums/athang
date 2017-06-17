@extends('Layouts.frontend')
<style>
    @media (max-width: 600px){
        .list-sp-home {
            margin-top: 0px !important;
        }
    }
</style>
@section('content')
    <div class="slideshow">
        <div class="slider-left">
            <div class="carousel slide" data-ride="carousel" id="myCarouselLeft">
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="{{ URL::asset('images/slides/left-01.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/left-02.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/left-03.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/left-04.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/left-05.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/left-06.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/left-07.jpg')}}"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-right">
            <div class="carousel slide" data-ride="carousel" id="myCarouselRight">
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="{{ URL::asset('images/slides/righ-01.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/righ-02.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/righ-03.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/righ-04.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/righ-05.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/righ-06.jpg')}}"/>
                    </div>
                    <div class="item">
                        <img src="{{ URL::asset('images/slides/righ-07.jpg')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="title-sp">
        <img class="imgup" src="{{ URL::asset('images/bg-sp-ln.png')}}"/>
        <div class="cover-img-glass">
            <div class="cover-p-sp">
                <p>Với vốn đầu tư lên hàng tỷ đồng. Nông nghiệp Lộc Ninh nghiên cứu chăn nuôi và giống cây trồng của chính miền đất Lộc Ninh-Bình Phước.
                    Chúng tôi cung cấp tất cả các loại cây giống cao su, cây điều. Bên cạnh đó là quy trình nuôi bò khép kín giúp đưa
                    ra thị trường giống bò tốt và chất lượng nhất.</p>
            </div>
        </div>
    </div>
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
        <div class="cover-bt-view-more">
            <a class="bt-view-more" href="{{ URL::to('/nong-nghiep') }}">Xem nhiều hơn</a>
        </div>
    </div>
    <div class="list-sp-home">
        <img class="title-list-sp" src="{{ URL::asset('images/title-channuoi.png')}}"/>
        <div class="cover-list-sp">
            @foreach($listCNHome as $item)
                <div class="item-sp">
                    <a class="a-cover-img" href="{{ URL::to('/chan-nuoi/'.$item->id.'/'.str_slug($item->name, '-')) }}"><img src="{{$item->thumb}}"/></a>
                    <div class="cv-img"><img class="img-cover-a" src="./images/bg-title-sp.png"/></div>
                    <a class="a-sp" href="{{ URL::to('/chan-nuoi/'.$item->id.'/'.str_slug($item->name, '-')) }}">{{$item->name}}</a>
                </div>
            @endforeach
        </div>
        <div class="cover-bt-view-more">
            <a class="bt-view-more" href="{{ URL::to('/chan-nuoi') }}">Xem nhiều hơn</a>
        </div>
    </div>
@stop