@extends('Layouts.frontend')

@section('content')
    <div class="list-sp-home">
        <img class="title-list-sp" src="{{ URL::asset('images/title-channuoi.png')}}"/>
        <div class="cover-list-sp">
            <img class="name-sp" src="{{ URL::asset('images/bg-title-sp.png')}}"/>
            <p class="name-p-sp">{{$spDetail->name}}</p>
            <div class="cover-image-sp">
                <h4 class="title-image">Hình Ảnh Về Sản Phẩm</h4>
                <div class="inner-cover-image">
                    <div class='list-group gallery'>
                        @foreach($spDetail->images as $item)
                            <div class='cover-item-detail'>
                                <a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::asset($item['small'])}}">
                                    <img class="img-responsive" alt="" src="{{ URL::asset($item['large'])}}" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="cover-image-sp">
                <h4 class="title-image">Video Về Sản Phẩm</h4>
                <div class="inner-cover-image">
                    @foreach($listVideos as $item)
                        <div class="item-video">
                            <h4 class="title-vid">{{$item->name}}</h4>
                            <span>Ngày đăng: {{date_format(date_create($item->created_at),"d/m/Y")}}</span>
                            <iframe width="100%" height="290" src="https://www.youtube.com/embed/{{$item->id_video}}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop