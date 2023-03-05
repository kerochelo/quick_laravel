@extends('adminlte::page')

@section('title', 'Super Blog!')

@section('content_header')
  <h1>著者</h1>
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
    <div class="row">
      <div class="col-md-9">
        <div class="box box-primary">
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-sm">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th></th>
                  <th>著者名</th>
                  <th>スラッグ</th>
                  <th>作成日</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($authors as $author)
                  <tr>
                    <td>{{ $author->id }}</td>
                    @if ($author->avatar)
                    <td><img width="16" height="16" src="{{ asset('storage/avatar/' . $author->avatar) }}" /></td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->slug }}</td>
                    <td>{{ $author->created_at }}</td>
                    <td><a href="{{ route('admin.authors.edit', $author) }}">編集</a></td>
                    <td><a href="{{ route('admin.authors.destroy', $author) }}">削除</a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">新規作成</h3>
          </div>
          <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
              <div class="form-group string required author_name">
                <label class="control-label string required" for="author_name"><abbr title="required">*</abbr> 著者名</label>
                <input class="form-control string required" type="text" name="name" id="author_name" value="{{ old('name') }}" />
              </div>
              <div class="form-group string required author_slug">
                <label class="control-label string required" for="author_slug"><abbr title="required">*</abbr> スラッグ</label>
                <input class="form-control string required" type="text" name="slug" id="author_slug" value="{{ old('slug') }}" />
              </div>
              <div class="form-group text optional author_profile">
                <label class="control-label text optional" for="author_profile">プロフィール</label>
                <textarea class="form-control text optional" name="profile" id="author_profile"></textarea>
              </div>
              <div class="form-group string required author_avatar">
                <label class="control-label string required" for="author_avatar">アバター</label>
                <input class="form-control string required" type="file" name="avata" id="author_avatar" />
              </div>
            </div>
            <div class="box-footer"><input type="submit" name="commit" value="登録する" class="btn btn-primary" data-disable-with="登録する" /></div>
          </form>
        </div>
      </div>
    </div>
  </section>
@stop
