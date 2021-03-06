@extends('layouts.m')

@section('title', '我的主页')

@section('header')
    @include('m.header', ['title' => '个人中心', 'theme' => 'white'])
@endsection

@section('content')
    <div class="position-relative" style="margin-top: 2.7rem;">
        <div class="bg-home" style="height: 220px;background: url({{ auth()->user()->bg_home }}) no-repeat center center / cover"></div>
        <div class="position-absolute" style="left: 0; top: 0; right: 0; bottom: 0;">
            <div class="d-flex align-items-center justify-content-center h-100">
                <span class="btn btn-outline-warning" onclick="javascript:$('#file_bg').trigger('click');">选一张好看的头图</span>
            </div>
        </div>
    </div>
    <div class="text-center">
        <p class="mb-0 position-relative">
            <img src="{{ auth()->user()->avatar }}" alt="头像" width="110" href="110" class="p-2 rounded-circle" style="background: rgba(255, 255, 255, .3); margin-top: -55px;">
        </p>
        <h5>{{ auth()->user()->name ?? auth()->user()->mobile }} <i class="fa {{ auth()->user()->sex === 'F' ? 'fa-venus text-danger' : 'fa-mars text-primary' }}"></i></h5>
        @if(auth()->user()->description)
            <small>现居：{{ auth()->user()->province ?? '未知' }} / {{ auth()->user()->city ?? '未知' }}</small>
            <p class="text-secondary">“{{ auth()->user()->description }}”</p>
        @else
            <p>
                <a href="{{ route('home.setting') }}" class="bg-light rounded text-secondary py-2 px-5 small">填写个人简介</a>
            </p>
        @endif
        <p>
            <a href="{{ route('home.travel.create') }}" class="btn btn-sm btn-warning py-2 px-5"><i class="fa fa-edit"></i> 发表游记</a>
        </p>
    </div>

    <input type="file" id="file_bg" accept="image/*" onchange="changeBg(event)" hidden>

    <div class="top-border">
        <div class="list-group">
            <a href="{{ route('home.travel.index') }}" class="list-group-item list-group-item-action d-flex align-items-center rounded-0 border-left-0 border-right-0">
                <i class="fa fa-fw fa-star text-info"></i> 我的游记
                <i class="fa fa-angle-right ml-auto"></i>
            </a>
            <a href="{{ route('home.message') }}" class="list-group-item list-group-item-action d-flex align-items-center rounded-0 border-left-0 border-right-0">
                <i class="fa fa-fw fa-comment-alt text-info"></i> 我的消息
                @if($numNotRead = auth()->user()->messages()->where('read', false)->count())
                    <span class="badge badge-danger ml-auto">{{ $numNotRead }}</span>
                @else
                    <i class="fa fa-angle-right ml-auto"></i>
                @endif
            </a>
            <a href="{{ route('home.order') }}" class="list-group-item list-group-item-action d-flex align-items-center rounded-0 border-left-0 border-right-0">
                <i class="fa fa-fw fa-list-alt text-info"></i> 我的订单
                <i class="fa fa-angle-right ml-auto"></i>
            </a>
            <a href="{{ route('home.setting') }}" class="list-group-item list-group-item-action d-flex align-items-center rounded-0 border-left-0 border-right-0">
                <i class="fa fa-fw fa-cog text-info"></i> 我的设置
                <i class="fa fa-angle-right ml-auto"></i>
            </a>
        </div>
    </div>
@endsection

@section('footer', false)

@push('script')
    <script>
        function changeBg(e) {
            let file = e.target.files[0];

            if (file.size / 1024 / 1024 >= 2) {
                return alert('请上传小于2MB的图片。');
            }

            let param = new FormData();
            param.append('bg', file)
            axios.post("{{ route('user.bg') }}", param, {
                headers: {'Content-Type': 'multipart/form-data'}
            }).then(res => {
                document.querySelector('.bg-home').style.backgroundImage = `url(${res.data.path + '?t=' + new Date().getTime()})`
            }).catch(err => {
                let errors = err.response.data.errors;
                swal('失败啦！', Object.values(errors).join("\r\n"), 'error');
            })
        }
    </script>
@endpush