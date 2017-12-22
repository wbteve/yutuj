@extends('layouts.app')

@section('title', '活动')

@section('content')
    <div class="container">
        <div id="banner" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#banner" data-slide-to="0" class="active"></li>
                <li data-target="#banner" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('uploads/d/list_banner_goods_1.jpg') }}" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('uploads/d/list_banner_goods_1.jpg') }}" alt="Second slide">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="py-4"><a href="{{ url('/') }}">首页</a> &gt; <span class="text-warning">活动</span></div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="bg-white mb-2 py-3 list-param">
                    <div class="row px-3">
                        <div class="col-1 text-nowrap">区域</div>
                        <div class="col-10 text-truncate">
                            <a href="#" class="active">全部</a>
                            <a href="#">四川</a>
                            <a href="#">云南</a>
                            <a href="#">青海</a>
                            <a href="#">西藏</a>
                            <a href="#">新疆</a>
                            <a href="#">贵州</a>
                            <a href="#">陕甘宁</a>
                            <a href="#">内蒙古</a>
                            <a href="#">广西</a>
                        </div>
                        <div class="col-1 text-nowrap">
                            <span class="text-warning">更多 <i class="fa fa-angle-down"></i></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white py-3 list-param">
                    <div class="row px-3">
                        <div class="col-1 text-nowrap">目的地</div>
                        <div class="col-10 text-truncate">
                            <a href="#" class="active">全部</a>
                            <a href="#">成都</a>
                            <a href="#">昆明</a>
                            <a href="#">西安</a>
                            <a href="#">拉萨</a>
                            <a href="#">西宁</a>
                            <a href="#">桂林</a>
                            <a href="#">林芝</a>
                            <a href="#">喀纳斯</a>
                            <a href="#">大理</a>
                            <a href="#">峨眉山</a>
                            <a href="#">丽江</a>
                            <a href="#">珠峰</a>
                        </div>
                        <div class="col-1 text-nowrap">
                            <span class="text-warning">更多 <i class="fa fa-angle-down"></i></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white list-param">
                    <div class="row px-3">
                        <div class="col-1 text-nowrap">时间</div>
                        <div class="col-10 text-truncate">
                            <a href="#" class="active">全部</a>
                            <a href="#">1月</a>
                            <a href="#">2月</a>
                            <a href="#">3月</a>
                            <a href="#">4月</a>
                            <a href="#">5月</a>
                            <a href="#">6月</a>
                            <a href="#">7月</a>
                            <a href="#">8月</a>
                            <a href="#">9月</a>
                            <a href="#">10月</a>
                            <a href="#">11月</a>
                            <a href="#">12月</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white py-3 list-param">
                    <div class="row px-3">
                        <div class="col-1 text-nowrap">价格</div>
                        <div class="col-10 text-truncate">
                            <a href="#" class="active">全部</a>
                            <a href="#">500元以下</a>
                            <a href="#">500-1000元</a>
                            <a href="#">1000以上</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white list-orderBy py-2 my-2">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);">综合排序 <i class="fa fa-angle-down"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);">价格 <i class="fa fa-angle-down"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);">发布时间 <i class="fa fa-angle-down"></i></a>
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-3 my-2 list-media">
                    @foreach($activities as $activity)
                        <div class="media">
                            <div class="mr-3 position-relative">
                                <a href="{{ route('www.activity.show', $activity) }}">
                                    <img src="{{ imageCut(280, 180, $activity->thumb) }}" alt="{{ $activity->short }}" width="280" height="180">
                                </a>
                                <span class="bg-warning text-white text-center p-1 position-absolute day">
                                    <b>{{ $loop->iteration }}</b>
                                    <br>DAY
                                </span>
                            </div>
                            <div class="media-body">
                                <a href="{{ route('www.activity.show', $activity) }}" class="text-warning d-block">
                                    <h3>{{ str_limit($activity->short, 30) }}</h3>
                                    <h5>{{ str_limit($activity->title, 80) }}</h5>
                                </a>
                                <p class="pt-2">
                                    <span class="text-info pr-3">行程</span>
                                    {{ str_limit($activity->xc, 90) }}
                                </p>
                                <p class="text-muted">
                                    <small>{{ $activity->description }}</small>
                                </p>
                                <h5 class="d-flex justify-content-between">
                                    <a href="javascript:void(0);" class="btn-fatuan text-info">出团日期 <i class="fa fa-lg fa-caret-down"></i></a>
                                    <span>￥{{ $activity->price }}/人</span>
                                </h5>
                                <div class="list-fatuan d-none">
                                    <table class="table text-nowrap">
                                        @foreach($activity->tuans as $tuan)
                                            <tr>
                                                <td class="align-middle">{{ $tuan->start_time->toDateString() }} - {{ $tuan->end_time->toDateString() }}</td>
                                                <td class="align-middle text-muted">已报名 {{ $tuan->start_num }} 人</td>
                                                <td class="align-middle text-danger">{{ $tuan->price }}元/人</td>
                                                <td class="align-middle text-right pr-3">
                                                    @if($tuan->available())
                                                        <a href="#{{ $tuan->id }}" class="btn btn-warning text-white btn-sm rounded-0">去报名</a>
                                                    @elseif($tuan->remainder() <= 0)
                                                        <a href="javascript:void(0);" class="btn btn-warning text-white btn-sm rounded-0 disabled">已满员</a>
                                                    @else
                                                        <a href="javascript:void(0);" class="btn btn-warning text-white btn-sm rounded-0 disabled">已结束</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <nav class="d-flex justify-content-end pt-5 w-100">
                        {{ $activities->appends(Request::only( 'pid', 'cid', '', 'field', 'order'))->links() }}
                    </nav>
                </div>
            </div>
            <div class="col-4 pl-0">
                <div class="bg-white mb-4 p-3">
                    <ul class="nav" role="tablist">
                        <li class="nav-item" style="margin-left: -15px;">
                            <a class="nav-link active" data-toggle="tab" href="#vp" role="tab">旅行短拍</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#zb" role="tab">大咖直播</a>
                        </li>
                    </ul>
                    <hr class="mt-2">
                    <div class="tab-content clearfix wan-video">
                        <div class="tab-pane fade show active" id="vp">
                            <div class="mb-4 position-relative">
                                <a href="#">
                                    <img src="{{ asset('uploads/d/list_2.jpg') }}" alt="list_2" class="img-fluid">
                                    <h5 class="position-absolute text text-truncate">世界很小，相遇在路上，泸沽湖纪念 旅途的点点滴滴</h5>
                                    <p class="position-absolute icon"><i class="fa fa-5x fa-play-circle-o"></i></p>
                                </a>
                            </div>
                            <a class="row text-right" href="#">
                                <span class="col-10">有361条旅行短拍</span>
                                <span class="col-2"><i class="fa fa-angle-right text-warning"></i></span>
                            </a>
                        </div>
                        <div class="tab-pane fade" id="zb">
                            <div class="mb-4 position-relative">
                                <a href="#">
                                    <img src="{{ asset('uploads/d/list_2.jpg') }}" alt="list_2" class="img-fluid">
                                    <h5 class="position-absolute text text-truncate">世界很大，相遇在路上，泸沽湖纪念 旅途的点点滴滴</h5>
                                    <p class="position-absolute icon"><i class="fa fa-5x fa-play-circle-o"></i></p>
                                </a>
                            </div>
                            <a class="row text-right" href="#">
                                <span class="col-10">有2361条旅行短拍</span>
                                <span class="col-2"><i class="fa fa-angle-right text-warning"></i></span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white mb-4 p-3">
                    <div class="text-warning">推荐攻略</div>
                    <hr>

                    <a href="#"><img src="{{ asset('uploads/d/list_2.jpg') }}" alt="list_2" class="img-fluid"></a>
                    <p class="px-4 py-2">骨灰级成都吃货地图，天啊再也没有哪比成都的馆子多了，24小时都能满足你的胃</p>

                    <a href="#"><img src="{{ asset('uploads/d/list_2.jpg') }}" alt="list_2" class="img-fluid"></a>
                    <p class="px-4 py-2">骨灰级成都吃货地图，天啊再也没有哪比成都的馆子多了，24小时都能满足你的胃</p>

                    <a href="#"><img src="{{ asset('uploads/d/list_2.jpg') }}" alt="list_2" class="img-fluid"></a>
                    <p class="px-4 py-2">骨灰级成都吃货地图，天啊再也没有哪比成都的馆子多了，24小时都能满足你的胃</p>

                    <a class="row text-right" href="#">
                        <span class="col-10">有2361条相关攻略</span>
                        <span class="col-2"><i class="fa fa-angle-right text-warning"></i></span>
                    </a>
                </div>

                <div class="bg-white p-3">
                    <div class="text-warning">精彩游记</div>
                    <hr>

                    <a href="#"><img src="{{ asset('uploads/d/list_2.jpg') }}" alt="list_2" class="img-fluid"></a>
                    <p class="px-4 py-2">骨灰级成都吃货地图，天啊再也没有哪比成都的馆子多了，24小时都能满足你的胃</p>

                    <a href="#"><img src="{{ asset('uploads/d/list_2.jpg') }}" alt="list_2" class="img-fluid"></a>
                    <p class="px-4 py-2">骨灰级成都吃货地图，天啊再也没有哪比成都的馆子多了，24小时都能满足你的胃</p>

                    <a href="#"><img src="{{ asset('uploads/d/list_2.jpg') }}" alt="list_2" class="img-fluid"></a>
                    <p class="px-4 py-2">骨灰级成都吃货地图，天啊再也没有哪比成都的馆子多了，24小时都能满足你的胃</p>

                    <a class="row text-right" href="#">
                        <span class="col-10">有2361条相关游记</span>
                        <span class="col-2"><i class="fa fa-angle-right text-warning"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <link href="https://cdn.bootcss.com/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
    <script>
        (function ($) {
            // 筛选 显示更多
            $('.list-param span').click(function () {
                $(this).children().toggleClass('fa-flip-vertical')
                $(this).parent().prev().toggleClass('text-truncate')
            })

            // 排序
            $('.list-orderBy a').click(function () {
                $(this).closest('.nav').find('a').removeClass('active')
                $(this).addClass('active')
                let fa = $(this).children()
                if (fa.css('opacity') === '1') {
                    fa.toggleClass('fa-flip-vertical')
                }
            })

            // 显示发团日期
            $('a.btn-fatuan').click(function () {
                $(this).children().toggleClass('fa-flip-vertical')
                $(this).closest('div').find('.list-fatuan').toggleClass('d-none').mCustomScrollbar()
            })
        })(jQuery);
    </script>
@endpush