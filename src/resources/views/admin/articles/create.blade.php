@extends('adminlte::page')

@section('title', '記事')

@section('content_header')
  <h1>記事の作成</h1>
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
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">新規作成</h3>
      </div>
      <form class="simple_form new_article" id="new_article" action="{{ route('admin.articles.store') }}" method="post">
        @csrf
        <div class="box-body">
          <div class="form-group string required article_title">
            <label class="control-label string required" for="article_title"><abbr title="required">*</abbr> タイトル</label>
            <input class="form-control string required" type="text" name="title" id="article_title" value="{{ old('title') }}" />
          </div>
          <div class="form-group string optional article_slug">
            <label class="control-label string optional" for="article_slug">スラッグ</label>
            <input class="form-control string optional" type="text" name="slug" id="article_slug" value="{{ old('slug') }}" />
          </div>
          <div class="form-group text optional article_description">
            <label class="control-label text optional" for="article_description">概要</label>
            <textarea class="form-control text optional" name="description" id="article_description">{{ old('description') }}</textarea>
          </div>
        </div>
        <div class="box-footer"><input type="submit" name="commit" value="登録する" class="btn btn-primary" data-disable-with="登録する" /></div>
      </form>
    </div>
  </section>
@stop
