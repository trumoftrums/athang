<html>
<html lang="en">
<head>
    <title>Nông Nghiệp Lộc Ninh</title>
    <meta charset="utf-8">
    <link href="{{ URL::asset('images/shortcut-icon.png')}}" rel="shortcut icon" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="INDEX,FOLLOW"/>
    <meta property="og:type" content="website" />
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style_nnln.css') }}?ver=1.1">
    <link rel="stylesheet" href="{{ URL::asset('css/media_screen.css') }}?ver=1.1">
    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</head>
<script>
    jQuery( document ).ready(function() {
        jQuery('#myCarouselLeft').carousel({
            interval: false
        });
        setInterval(function(){jQuery('#myCarouselLeft').carousel('prev'); }, 5000);

        jQuery('#myCarouselRight').carousel({
            interval: false
        });
        setInterval(function(){jQuery('#myCarouselRight').carousel('next'); }, 5000);
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });
    });
</script>
<div class="container-fluid">
    <div class="header-mobile">
        <div class="menu-header-mobile">
            <div class="dropdown">
                <span class="icon-menu" data-toggle="dropdown">
                    <img src="{{ URL::asset('images/icon-menu-mobile.png')}}"/>
                </span>
                <ul class="dropdown-menu">
                    <span class="close-menu"> <img src="{{ URL::asset('images/close-icon-white.png')}}"/> </span>
                    <ul id="nav-mobile">
                        <li class="parent"><a href="{{ URL::to('/') }}">Trang Chủ</a></li>
                        <li class="parent"><a href="{{ URL::to('nong-nghiep') }}">Nông Nghiệp</a></li>
                        <li class="parent"><a href="{{ URL::to('chan-nuoi') }}">Chăn Nuôi</a></li>
                        <li class="parent"><a href="{{ URL::to('lien-he') }}">Liên hệ</a></li>
                    </ul>
                </ul>
            </div>
        </div>
        <div class="logo-mobile">
            <a href="{{ URL::to('/') }}"><img class="logo-hsg" src="{{ URL::asset('images/logo.png')}}"/></a>
        </div>
        <div class="div-glass-mobile"></div>
    </div>
    <div class="header">
        <ul class="ul-menu-head">
            <li><a href="{{ URL::to('/') }}"><img src="{{ URL::asset('images/menu-home.png')}}"/></a></li>
            <li><a href="{{ URL::to('nong-nghiep') }}"><img src="{{ URL::asset('images/menu-nongnghiep.png')}}"/></a></li>
            <li class="menu-logo"><a href="{{ URL::to('/') }}"><img src="{{ URL::asset('images/logo.png')}}"/></a></li>
            <li><a href="{{ URL::to('chan-nuoi') }}"><img src="{{ URL::asset('images/menu-channuoi.png')}}"/></a></li>
            <li><a href="{{ URL::to('lien-he') }}"><img src="{{ URL::asset('images/menu-lienhe.png')}}"/></a></li>
        </ul>
    </div>
    <div class="div-glass"></div>
        @yield('content')
    <div class="footer-mobile">
        <a href="{{ URL::to('/') }}"><img src="{{ URL::asset('images/logo-footer.png')}}"/></a>
    </div>
    <div class="footer">
        <ul class="ul-menu-footer">
            <li><a href="{{ URL::to('/') }}"><img src="{{ URL::asset('images/menu-home-footer.png')}}"/></a></li>
            <li><a href="{{ URL::to('nong-nghiep') }}"><img src="{{ URL::asset('images/menu-nongnghiep-footer.png')}}"/></a></li>
            <li class="menu-logo"><a href="{{ URL::to('/') }}"><img src="{{ URL::asset('images/logo-footer.png')}}"/></a></li>
            <li><a href="{{ URL::to('chan-nuoi') }}"><img src="{{ URL::asset('images/menu-channuoi-footer.png')}}"/></a></li>
            <li><a href="{{ URL::to('lien-he') }}"><img src="{{ URL::asset('images/menu-lienhe-footer.png')}}"/></a></li>
        </ul>
    </div>
    <div class="copy-right">
        <p class="av">Địa chỉ: 2 Nguyễn Bính, Thị Trấn Lộc Ninh, Lộc Ninh, Bình Phước, Việt Nam</p>
        <p class="av">Email: nongnghieplocninh@gmail.com</p>
        <p class="av">Phone: 0946 190 069 (gặp A.Phong)</p>
        <p class="copyright">Bản quyền @2017 nongnghieplocninh.com</p>
    </div>
</div>
</html>