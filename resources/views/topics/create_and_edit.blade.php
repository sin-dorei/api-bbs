@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card">

      <div class="card-body">
        <h2 class="">
          <i class="far fa-edit"></i>
          @if($topic->id)
          编辑话题
          @else
          新建话题
          @endif
        </h2>

        <hr>

        @if($topic->id)
        <form action="{{ route('topics.update', $topic) }}" method="POST">
          <input type="hidden" name="_method" value="PUT">
          @else
          <form action="{{ route('topics.store') }}" method="POST">
            @endif

            @csrf

            @include('shared._error')

            <div class="form-group">
              <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title) }}"
                placeholder="请填写标题" />
            </div>

            <div class="form-group">
              <select class="form-control" name="category_id">
                <option value="" hidden disabled selected>请选择分类</option>
                @foreach ($categories as $value)
                <option value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              {{-- <textarea name="body" id="editor" placeholder="请填入至少三个字符的内容">{{ old('body', $topic->body) }}</textarea>
              --}}
              <textarea id="editor">
              </textarea>
            </div>

            <div class="well well-sm">
              <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2"></i>
                保存</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

@stop

@section('styles')

<link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">

@stop

@section('scripts')

<script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

<script>
  $(document).ready(function() {
      var editor = new Simditor({
        textarea: $('#editor'),
      });
    });
</script>

@stop
















{{-- <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script>
  tinymce.init({
    selector: '#editor',
    language: 'zh_CN',
    plugins: 'image axupimgs',
    toolbar1: 'code undo redo | forecolor backcolor bold italic underline strikethrough link | alignleft aligncenter alignright alignjustify outdent indent',
    toolbar2: 'blockquote subscript superscript removeformat | image axupimgs',
    images_upload_url: '{{ route("topics.upload_image") }}',
    images_upload_handler: function (blobInfo, succFun, failFun) {
        var xhr, formData;
        var file = blobInfo.blob();//转化为易于理解的file对象
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{{ route("topics.upload_image") }}');
        xhr.setRequestHeader("X-CSRF-Token", '{{ csrf_token() }}');
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failFun('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                failFun('Invalid JSON: ' + xhr.responseText);
                return;
            }
            succFun(json.location);
        };
        formData = new FormData();
        formData.append('file', file, file.name );
        xhr.send(formData);
    },
    menubar: false,
    statusbar: false
  });
</script> --}}


