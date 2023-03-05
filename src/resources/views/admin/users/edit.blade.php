@extends('adminlte::page')

@section('title', 'Super Blog!')

@section('content_header')
  <h1>ユーザープロフィール</h1>
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
    <div class="row">
      <div class="col-md-3">
        <div class="box box-primary">
          <div class="box-body box-profile">
            @if ($user->avatar)
            <img class="profile-user-img img-responsive img-circle" src="{{ asset('storage/avatar/' . $user->avatar) }}" />
            @endif
            <h3 class="profile-username text-center">{{ $user->name }}</h3>
            <p class="text-muted text-center">{{ $user->getRoleName($user->role_id) }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#settings">設定</a></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="settings">
              <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group string required user_name">
                  <label class="control-label string required" for="user_name"><abbr title="required">*</abbr> 名前</label>
                  <input class="form-control string required" type="text" value="{{ $user->name }}" name="name" id="user_name" />
                </div>
                <div class="form-group string required user_email">
                  <label class="control-label string required" for="user_email"><abbr title="required">*</abbr> メールアドレス</label>
                  <input class="form-control string required" type="text" value="{{ $user->email }}" name="email" id="user_email" />
                </div>
                <div class="form-group string required user_role_id">
                  <label class="control-label string required" for="user_role_id"><abbr title="required">*</abbr> 役割</label>
                  <select class="form-control" id="user_role_id" name="role_id">
                  @foreach($roles as $role)
                      <option value="{{ $role->id }}"
                        @if($user->role_id == $role->id) selected
                        @endif
                      >{{ $role->name }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="form-group string required user_avatar">
                  <label class="control-label string required" for="user_avatar">アバター</label>
                  <input class="form-control string required" type="file" name="avatar" id="user_avatar" />
                </div>
                <div class="form-group password optional user_password">
                  <label class="control-label password optional" for="user_password">パスワード</label>
                  <input class="form-control password optional" type="password" name="password" id="user_password" />
                </div>
                <div class="form-group password optional user_password_confirmation">
                  <label class="control-label password optional" for="user_password_confirmation">パスワード再入力</label>
                  <input class="form-control password optional" type="password" name="password_confirmation" id="user_password_confirmation" />
                </div>
                <input type="submit" name="commit" value="更新" class="btn btn-danger" data-disable-with="更新" /></form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop
