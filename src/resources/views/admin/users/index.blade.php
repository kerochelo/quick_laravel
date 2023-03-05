@extends('adminlte::page')

@section('title', 'Super Blog!')

@section('content_header')
  <h1>ユーザー</h1>
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
                  <th>ユーザー名</th>
                  <th>役割</th>
                  <th>作成日</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td>{{ $user->id }}</td>
                    @if ($user->avatar)
                    <td><img width="16" height="16" src="{{ asset('storage/avatar/' . $user->avatar) }}" /></td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $user->name }}</td>
                    @if($user->role_id)
                    <td>{{ $user->getRoleName($user->role_id) }}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{ $user->created_at }}</td>
                    <td><a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info">編集</a></td>
                    <td>
                      <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">削除</button>
                      </form>
                    </td>
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
          <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
              <div class="form-group string required user_name">
                <label class="control-label string required" for="user_name"><abbr title="required">*</abbr> 名前</label>
                <input class="form-control string required" type="text" name="name" id="user_name" />
              </div>
              <div class="form-group string required user_email">
                <label class="control-label string required" for="user_email"><abbr title="required">*</abbr> メールアドレス</label>
                <input class="form-control string required" type="text" name="email" id="user_email" />
              </div>
              <div class="form-group string required user_role_id">
                <label class="control-label string required" for="user_role_id"><abbr title="required">*</abbr> 役割</label>
                <select class="form-control" id="user_role_id" name="role_id">
                  @foreach($roles as $role)
                  <option value="{{ $role->id }}">{{ $role->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group string required user_avatar">
                <label class="control-label string required" for="user_avatar">アバター</label>
                <input class="form-control string required" type="file" name="avata" id="user_avatar" />
              </div>
              <div class="form-group password optional user_password">
                  <label class="control-label password optional" for="user_password">パスワード</label>
                  <input class="form-control password optional" type="password" name="password" id="user_password" />
                </div>
                <div class="form-group password optional user_password_confirmation">
                  <label class="control-label password optional" for="user_password_confirmation">パスワード再入力</label>
                  <input class="form-control password optional" type="password" name="password_confirmation" id="user_password_confirmation" />
                </div>
            </div>
            <div class="box-footer"><input type="submit" name="commit" value="登録する" class="btn btn-primary" data-disable-with="登録する" /></div>
          </form>
        </div>
      </div>
    </div>
  </section>
@stop
