@extends('layouts.m')

@section('title', '我的设置')

@section('header', false)

@section('content')
    <header class="position-absolute bg-white container-fluid">
        <div class="text-warning row">
            <span class="col-3" onclick="history.back();"><i class="fas fa-lg fa-angle-left"></i></span>
            <span class="col text-center">绑定手机</span>
            <span class="col-3 text-right">&nbsp;</span>
        </div>
    </header>
    <form class="container-fluid mt-5 pt-3" id="userTel">
        <div class="form-group">
            <input type="tel" name="mobile" class="form-control" placeholder="绑定手机号">
        </div>
        <div class="form-group position-relative">
            <span class="btn-sm btn-warning position-absolute px-3" onclick="sendCode()" style="right: 5px; top: 5px;">获取短信验证码</span>
            <input type="text" name="code" class="form-control" placeholder="输入验证码">
            <small class="form-text text-muted">
                <i class="fa fa-info-circle"></i> 短信发送至原手机，无法获取请联系在线客服。
            </small>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-warning">确认</button>
        </div>
        <div class="form-group pb-2">
            <span class="text-danger" id="errmsg"></span>
        </div>
    </form>
@endsection

@section('footer', false)

@push('script')
    <script>
        $('#userTel').submit(function (event) {
            event.preventDefault()
            let param = $(this).serialize()
            axios.put("{{ route('user.mobile') }}", param).then(res => {
                alert(res.data.message);
                location.href = document.referrer
            }).catch(err => {
                let errors = err.response.data.errors
                let e = Object.values(errors).join('')
                let errhtml = '<i class="fa fa-fw fa-info-circle"></i>' + e
                $('#errmsg').html(errhtml)
            })
        })

        @if(auth()->user()->mobile)
        function sendCode() {
            axios.post("{{ url('sms/update') }}").then(res => {
                swal('发送成功！', res.data.message, 'success')
            }).catch(err => {
                let errors = err.response.data.errors;
                swal('发送失败！', Object.values(errors).join(''), 'error')
            })
        }

        @else
        function sendCode() {
            let mobile = document.querySelector('[name="mobile"]').value
            axios.post("{{ url('sms/register') }}", {mobile}).then(res => {
                swal('发送成功！', res.data.message, 'success')
            }).catch(err => {
                let errors = err.response.data.errors;
                swal('发送失败！', Object.values(errors).join(''), 'error')
            })
        }
        @endif
    </script>
@endpush
