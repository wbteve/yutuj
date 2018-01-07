<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ config('web_title') }}</title>
    <meta name="author" content="bing,QQ676659348">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ config('web_keywords') }}">
    <meta name="description" content="{{ config('web_description') }}">
    <script defer src="{{ asset('js/fontawesome.all.js') }}"></script>
    {{--Bootstrap--}}
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta.2/js/bootstrap.bundle.min.js"></script>

    {{--图片占位符--}}
    <script src="https://cdn.bootcss.com/holder/2.9.4/holder.min.js"></script>

    {{--弹窗组件--}}
    <link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>

    {{--WEB样式--}}
    <link href="{{ asset('m/css/css.css') }}" rel="stylesheet">
    <script src="{{ asset('m/js/bing.js') }}"></script>
</head>
<body>
@section('header')

@show

@yield('content')

@section('footer')
    <footer class="top-border text-center py-2 font-weight-light">
        <ul class="nav nav-justified text-nowrap mb-2">
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('/') }}">
                    <i class="fa fa-home"></i>
                    <br>返回首页
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fa fa-user"></i>
                    <br>我的遇途记
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fa fa-list-alt"></i>
                    <br>我的订单
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://yutuj.com" target="_blank">
                    <i class="fa fa-desktop"></i>
                    <br>电脑版
                </a>
            </li>
        </ul>
        <div class="small">
            <p><a href="#">关于我们</a> | <a href="#">联系我们</a></p>
            <p class="text-secondary">
                {!! nl2br(config('web_footer')) !!}
                {!! config('js_mobile') !!}
            </p>
        </div>
        <span class="return-top">
            <i class="fa fa-2x fa-arrow-alt-circle-up"></i>
        </span>
    </footer>
@show

@stack('script')
</body>
</html>