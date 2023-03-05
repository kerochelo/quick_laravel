@extends('adminlte::page')

@section('title', 'Super Blog!')

@section('content_header')
  <h1>著者編集</h1>
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
      <form action="{{ route('admin.authors.update', $author) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="box-body">
        <div class="form-group string required tag_name">
          <label class="control-label string required" for="author_name"><abbr title="required">*</abbr> 著者名</label>
          <input class="form-control string required" type="text" value="{{ $author->name }}" name="name" id="author_name" />
        </div>
        <div class="form-group string required author_slug">
          <label class="control-label string required" for="author_slug"><abbr title="required">*</abbr> スラッグ</label>
          <input class="form-control string required" type="text" value="{{ $author->slug }}" name="slug" id="author_slug" />
        </div>
        <div class="form-group text optional author_profile">
          <label class="control-label text optional" for="author_profile">プロフィール</label>
          <textarea class="form-control text optional" name="profile" id="author_profile">{{ $author->profile }}</textarea>
        </div>
        <div class="form-group string required author_avatar">
          <label class="control-label string required" for="author_avatar">アバター</label>
          <input class="form-control string required" type="file" name="avatar" id="author_avatar" />
        </div>
      </div>
      <div class="box-footer"><input type="submit" name="commit" value="更新する" class="btn btn-primary" data-disable-with="更新する" /></div>
      </form>
    </div>
  </section>
@stop
