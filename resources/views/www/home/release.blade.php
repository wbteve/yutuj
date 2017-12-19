@extends('layouts.app')

@section('title', (auth()->user()->name ?? auth()->user()->mobile) . '的游记')

@section('content')
    <div class="container pt-4">
        <div class="bg-white home-release float-left">
            <h6 class="p-3" style="border-bottom: 1px solid #EEEEEE;">草稿箱（{{ auth()->user()->travels()->status('draft')->count() }}）</h6>
            <ul class="list-unstyled px-3 clearfix">
                @forelse(auth()->user()->travels()->status('draft')->get() as $travel)
                    <li>
                        <span class="float-left">
                            <a href="{{ route('travel.show', $travel) }}">{{ str_limit($travel->title, 30) }}</a><br>
                            <small>{{ $travel->updated_at }}</small>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('travel.edit', $travel) }}" class="fa fa-fw fa-lg fa-edit"></a>
                            <a href="javascript:void(0);" class="fa fa-fw fa-lg fa-trash-o btn-del" data-action="{{ route('travel.destroy', $travel) }}"></a>
                        </span>
                    </li>
                @empty
                    <li>
                        <i class="fa fa-fw fa-info-circle"></i> 没有草稿记录
                    </li>
                @endforelse
            </ul>
        </div>
        <div class="bg-white home-travels float-right p-4">
            <form id="releaseForm">
                <input type="hidden" name="province" id="province">
                <input type="hidden" name="city" id="city">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="这里输入游记标题" name="title">
                </div>
                <div class="form-group">
                    <p><img class="img-thumbnail d-none showImage" alt="缩略图" width="870"></p>
                    <label class="custom-file">
                        <input type="file" id="thumb" name="thumb" class="custom-file-input">
                        <span class="custom-file-control text-muted">选择游记封面</span>
                    </label>
                </div>
                <div class="form-group">
                    <textarea name="description" class="form-control text-muted" rows="3" placeholder="游记的摘要也很重要…"></textarea>
                </div>
                <div class="form-group">
                    <div id="edit"></div>
                    <textarea name="body" hidden class="form-control" rows="10" placeholder="请在这里编辑游记内容"></textarea>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" checked>
                        我已阅读并同意<span class="text-warning">《遇途记游记协议》</span>
                    </label>
                </div>
                <div class="text-right">
                    <span class="btn btn-warning text-white px-4 py-1" onclick="release('audit')">确认发表</span>
                    <span class="btn btn-outline-warning px-4 py-1" onclick="release('draft')">保存草稿</span>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="release" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document" style="top: 30%;">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <span class="close" data-dismiss="modal">&times;</span>
                    <div class="pt-4 pb-2 icon">
                        <span class="fa fa-fw fa-exclamation-circle fa-4x text-danger"></span>
                        <span class="fa fa-fw fa-smile-o fa-4x text-success"></span>
                    </div>
                    <p class="text-muted font-weight-light msg">未填写完成的消息提示</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <link rel="stylesheet" href="{{ asset('/vendor/wangEditor-3.0.14/release/wangEditor.min.css') }}">
    <script src="{{ asset('/vendor/wangEditor-3.0.14/release/wangEditor.min.js') }}"></script>
    <script>
        let editor = new wangEditor('#edit')
        $(document).ready(function () {
            initEdit();

            // 刷新默认显示缩略图
            $('#thumb').change(function () {
                let src = window.URL.createObjectURL(this.files[0])
                $('.showImage').prop('src', src).removeClass('d-none')
                $(this).next().text($(this).val())
            })
            if ($('#thumb').val() !== '') {
                $('#thumb').trigger('change')
            }

            // 删除
            $('.btn-del').click(function () {
                if (!confirm('确认要删除吗')) {
                    return
                }
                let url = $(this).data('action')
                let li = $(this).closest('li')
                axios.delete(url).then(res => {
                    li.remove()
                })
            })

            // 获取当前地理位置
            $.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js', function () {
                if ($('#province').val() === '') {
                    $('#province').val(remote_ip_info.province)
                }
                if ($('#city').val() === '') {
                    $('#city').val(remote_ip_info.city)
                }
            })
        })

        /**
         * 编辑器
         */
        function initEdit() {
            editor.customConfig.uploadImgShowBase64 = true
            editor.customConfig.zIndex = 1
            editor.customConfig.onchange = function (html) {
                $('[name="body"]').val(html)
            }
            editor.create()

            let t = $('[name="body"]').val()
            editor.txt.html(t);
        }

        /**
         * 发布修改
         * @param status draft:草稿
         */
        function release(status = 'draft') {
            let modal = $('#release')
            let msg = modal.find('.msg')
            let icon = modal.find('.icon > span')
            let param = new FormData(document.getElementById('releaseForm'));
            param.append('status', status)
            axios.post("{{ route('travel.store') }}", param, {
                headers: {'Content-Type': 'multipart/form-data'}
            }).then(res => {
                msg.text(res.data.message)
                icon.eq(1).show()
                icon.eq(2).hide()
                return modal.modal('show')
            }).catch(err => {
                let errors = err.response.data.errors;
                msg.html(Object.values(errors).join("<br>"))
                icon.eq(0).show()
                icon.eq(1).hide()
                return modal.modal('show')
            })
        }
    </script>
@endpush