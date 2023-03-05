@extends('adminlte::page')

@section('title', 'Super Blog!')

@section('content_header')
  <h1>サイトの設定</h1>
@stop

@section('content')
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ __($error) }}</li>
        @endforeach
      </ul>
    </div>
	@endif

  @if (session('flash_message'))
    <script>
      toastr["success"]("{{ session('flash_message') }}");
    </script>
  @endif

  <section class="content">
    <div class="box box-primary">
      <form class="simple_form edit_site" id="edit_site" action="{{ route('admin.sites.update', $site->id) }}" method="POST"  enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="box-body">
          <div class="form-group string required site_name">
            <label class="control-label string required" for="site_name"><abbr title="required">*</abbr> サイト名</label>
            <input class="form-control string required" type="text" value="{{ $site->name }}" name="name" id="site_name" />
          </div>
          <div class="form-group string optional site_subtitle">
            <label class="control-label string optional" for="site_subtitle">サブタイトル</label>
            <input class="form-control string optional" type="text" value="{{ $site->subtitle }}" name="subtitle" id="site_subtitle" />
          </div>
          <div class="form-group text optional site_description">
            <label class="control-label text optional" for="site_description">概要</label>
            <textarea class="form-control text optional" name="description" id="site_description">{{ $site->description }}</textarea>
          </div>
          <div class="form-group file optional site_favicon">
            <label class="control-label file optional" for="site_favicon">favicon</label>
            <input class="file optional" type="file" name="favicon" id="site_favicon" />
            <p class="help-block">PNG (32x32)</p>
          </div>
          @if($site->favicon)
          <img src="{{ asset('storage/favicon/' . $site->favicon) }}" /><br /><br />
          <a class="btn btn-danger" rel="nofollow" data-method="delete" href="{{ route('admin.sites.del_favicon', $site) }}">削除</a><br /><br />
          @endif

          <div class="form-group file optional site_og_image">
            <label class="control-label file optional" for="site_og_image">og:image</label>
            <input class="file optional" type="file" name="og_image" id="site_og_image" />
            <p class="help-block">JPEG/PNG (1200x630)</p>
          </div>
          @if($site->og_image)
          <img src="{{ asset('storage/og_image/' . $site->og_image) }}" /><br /><br />
          <a class="btn btn-danger" rel="nofollow" data-method="delete" href="{{ route('admin.sites.del_og_image', $site) }}">削除</a><br /><br />
          @endif

          <div class="form-group file optional site_main_image">
            <label class="control-label file optional" for="site_main_image">Main image</label>
            <input class="file optional" type="file" name="main_image" id="site_main_image" />
            <p class="help-block">JPEG/PNG (1200x400)</p>
          </div>
          <div class="main_images_box">
            @if($site->main_image)
            <div class="main_image">
              <img src="{{ asset('storage/main_image/' . $site->main_image) }}" />
              <a class="btn btn-danger" rel="nofollow" data-method="delete" href="{{ route('admin.sites.del_main_image', $site) }}">削除</a>
            </div>
            @endif
          </div>
        </div>
        <div class="box-footer"><input type="submit" name="commit" value="保存" class="btn btn-primary" data-disable-with="保存" /></div>
      </form>
    </div>
  </section>
@stop
