@extends('adminlte::page')

@section('title', 'Super Blog!')

@section('content_header')
  <h1>タグ編集</h1>
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

  <section class="content">
    <div class="box">
      <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
      @csrf
      <div class="box-body">
        <div class="form-group string required tag_name">
          <label class="control-label string required" for="tag_name"><abbr title="required">*</abbr> タグ名</label>
          <input class="form-control string required" type="text" value="{{ $tag->name }}" name="name" id="tag_name" />
        </div>
        <div class="form-group string required tag_slug">
          <label class="control-label string required" for="tag_slug"><abbr title="required">*</abbr> スラッグ</label>
          <input class="form-control string required" type="text" value="{{ $tag->slug }}" name="slug" id="tag_slug" />
        </div>
      </div>
      <div class="box-footer"><input type="submit" name="commit" value="更新する" class="btn btn-primary" data-disable-with="更新する" /></div>
      </form>
    </div>
  </section>
@stop
