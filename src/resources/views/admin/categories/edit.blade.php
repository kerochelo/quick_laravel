@extends('adminlte::page')

@section('title', 'カテゴリー')

@section('content_header')
  <h1>カテゴリー編集</h1>
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
      <form action="{{ route('admin.categories.update', $category) }}" method="POST">
      @csrf
      <div class="box-body">
        <div class="form-group string required category_name">
          <label class="control-label string required" for="category_name"><abbr title="required">*</abbr> カテゴリー名</label>
          <input class="form-control string required" type="text" value="{{ $category->name }}" name="name" id="category_name" />
        </div>
        <div class="form-group string required category_slug">
          <label class="control-label string required" for="category_slug"><abbr title="required">*</abbr> スラッグ</label>
          <input class="form-control string required" type="text" value="{{ $category->slug }}" name="slug" id="category_slug" />
        </div>
      </div>
      <div class="box-footer"><input type="submit" name="commit" value="更新する" class="btn btn-primary" data-disable-with="更新する" /></div>
      </form>
    </div>
  </section>
@stop
