@extends('adminlte::page')

@section('title', '記事')

@section('content_header')
  <h1>記事</h1>
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
      <div class="box-header">
        <h3 class="box-title">記事一覧</h3>
        <div class="box-tools">
          <div class="ul list-inline">
            <li>
              <form class="form-inline" action="{{ route('admin.articles.search') }}" method="post">
                @csrf
                <select class="form-control" name="category_id">
                  <option value="">カテゴリ</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
                <select class="form-control" name="author_id">
                  <option value="">著者</option>
                  @foreach($authors as $author)
                  <option value="{{ $author->id }}">{{ $author->name }}</option>
                  @endforeach
                </select>
                <select class="form-control" name="tag_id">
                  <option value="">タグ</option>
                  @foreach($tags as $tag)
                  <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                  @endforeach
                </select>
                <input class="form-control" placeholder="記事内容" type="search" name="body" />
                <div class="input-group">
                  <input placeholder="タイトル" class="form-control" type="search" name="title" />
                  <span class="input-group-btn">
                    <input type="submit" name="commit" value="検索" class="btn btn-default btn-flat" data-disable-with="検索" />
                  </span>
                </div>
              </form>
            </li>
            <li></li>
            <div class="pull-right"><a class="btn btn-primary" href="{{ route('admin.articles.create') }}">新規作成</a></div>
          </div>
        </div>
      </div>
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>タイトル</th>
              <th>カテゴリー</th>
              <th>タグ</th>
              <th>著者</th>
              <th>公開日</th>
            </tr>
          </thead>
          <tbody>
            @foreach($articles as $article)
            <tr>
              <td>{{ $article->id }}</td>
              <td>
                <div>{{ $article->title }}</div>
                <div>
                  <a class="btn btn-default btn-xs btn-flat" href="{{ route('admin.articles.edit', $article) }}">
                    <i class="fa fa-edit"></i> 編集
                  </a>
                  @if($article->slug)
                  <a class="btn btn-default btn-xs btn-flat" target="_blank" href="{{ route('blogs.show', $article->slug) }}">
                    <i class="fa fa-eye"></i> プレビュー
                  @else
                  <a class="btn btn-default btn-xs btn-flat disabled">
                    <i class="fa fa-eye"></i> プレビュー
                  @endif
                  </a>
                  <a class="btn btn-link btn-xs btn-flat" rel="nofollow" data-method="delete" href="{{ route('admin.articles.delete', $article) }}">
                    <i class="fa fa-trash"></i> 削除
                  </a>
                </div>
              </td>

              @if($article->category_id)
                @foreach($categories as $category)
                  @if($category->id == $article->category_id)
                  <td>{{ $category->name }}</td>
                  @endif
                @endforeach
              @else
                <td></td>
              @endif

              @if(count($article->tags)>0)
              <td>
              @foreach($article->tags as $articleTag)
                @foreach($tags as $tag)
                  @if($tag->id == $articleTag->tag_id)
                  <span class="label label-info">{{ $tag->name }}</span>
                  @endif
                @endforeach
              @endforeach
              </td>
              @else
              <td></td>
              @endif

              @if ($article->author_id)
                @foreach($authors as $author)
                  @if($author->id == $article->author_id)
                  <td>{{ $author->name }}</td>
                  @endif
                @endforeach
              @else
              <td></td>
              @endif

              <td>
                <div>
                @if ($article->state == 0)
                <span class="label label-warning">下書き</span>
                @else
                <span class="label label-success">公開</span>
                @endif
                </span></div>
                <div>{{ $article->published_at }}</div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="box-footer">
        <div class="pull-right"></div>
      </div>
    </div>
  </section>

@stop
