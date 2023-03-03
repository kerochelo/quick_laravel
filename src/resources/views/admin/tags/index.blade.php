@extends('adminlte::page')

@section('title', 'Super Blog!')

@section('content_header')
  <h1>タグ</h1>
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
                  <th>タグ名</th>
                  <th>スラッグ</th>
                  <th>作成日</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tags as $tag)
                  <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td>{{ $tag->created_at }}</td>
                    <td><a href="{{ route('admin.tags.edit', $tag) }}">編集</a></td>
                    <td><a href="{{ route('admin.tags.destroy', $tag) }}">削除</a></td>
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
          <form action="{{ route('admin.tags.store') }}" method="POST">
            @csrf
            <div class="box-body">
              <div class="form-group string required tag_name">
                <label class="control-label string required" for="tag_name"><abbr title="required">*</abbr> タグ名</label>
                <input class="form-control string required" type="text" name="name" id="tag_name" value="{{ old('name') }}" />
              </div>
              <div class="form-group string required tag_slug">
                <label class="control-label string required" for="tag_slug"><abbr title="required">*</abbr> スラッグ</label>
                <input class="form-control string required" type="text" name="slug" id="tag_slug" value="{{ old('slug') }}" />
              </div>
            </div>
            <div class="box-footer"><input type="submit" name="commit" value="登録する" class="btn btn-primary" data-disable-with="登録する" /></div>
          </form>
        </div>
      </div>
    </div>
  </section>
@stop
