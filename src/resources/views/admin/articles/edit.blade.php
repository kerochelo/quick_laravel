@extends('adminlte::page')

@section('title', '記事')

@section('content_header')
  <h1>記事編集</h1>
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
  <form class="simple_form edit_article" id="edit_article" enctype="multipart/form-data" action="{{ route('admin.articles.update', $article) }}" method="post">
    @method('PUT')
    @csrf
      <div class="row">
        <div class="col-md-8">
          <div class="js-article-block-forms">

          <table id="dynamicAddRemove">
              @if(count($article->bodies) > 0)
              @php
                $i = 0;
              @endphp
              @foreach($article->bodies as $articleBody)
              <tr>
                <td>
                  @php
                    $idx = sprintf('%03d', $i);
                    $i++;
                    @endphp
                  <trix-editor class="trix-content" input="x{{ $idx }}">{!! $articleBody->body !!}</trix-editor>
                  <input id="x{{ $idx }}" type="hidden" name="body{{ $idx }}" value="{!! $articleBody->body !!}">
                </td>
                <td>
                  @if($idx == '00')
                  <button type="button" name="add" id="add-btn" class="btn btn-success">追加</button>
                  @else
                  <button type="button" class="btn btn-danger remove-tr">削除</button>
                  @endif
                </td>
              </tr>
              @endforeach
              @php
                $pi = $i -1;
              @endphp
              <input type="hidden" id= "php_idx" name="php_idx" value="{{ $pi }}">

              @else
              <tr>
                <td>
                  <trix-editor input="x000"></trix-editor>
                  <input id="x000" type="hidden" name="body000">
                </td>
                <td>
                  <button type="button" name="add" id="add-btn" class="btn btn-success">追加</button>
                </td>
              </tr>
              <input type="hidden" id= "php_idx" name="php_idx" value="0">
              @endif

            </table>

          </div>
        </div>

        <div class="col-md-4">
          <div class="box box-solid box-info">
            <div class="box-header">
              <h3 class="box-title">情報</h3>
            </div>
              <div class="box-body">
                <div class="form-group"><label class="control-label">状態</label>
                  @if ($article->state == 0)
                  <div class="form-control">下書き</div>
                  @else
                  <div class="form-control">公開</div>
                  @endif
                </div>
                <div class="form-group date_time_picker optional article_published_at">
                  <label class="control-label date_time_picker optional" for="article_published_at">公開日</label>
                  <div class="input-group date js-datetimepicker">
                    <input class="date_time_picker optional form-control" type="text" name="published_at" id="article_published_at" value="{{ $article->published_at }}" />
                    <span class="input-group-addon"><span class='glyphicon glyphicon-calendar'></span></span>
                  </div>
                </div>
                <div class="form-group string required article_title">
                  <label class="control-label string required" for="article_title"><abbr title="required">*</abbr> タイトル</label>
                  <input class="form-control string required" type="text" value="{{ $article->title }}" name="title" id="article_title" />
                </div>
                <div class="form-group string optional article_slug">
                  <label class="control-label string optional" for="article_slug">スラッグ</label>
                  <input class="form-control string optional" type="text" value="{{ $article->slug }}" name="slug" id="article_slug" />
                </div>
                <div class="form-group file optional article_eyecache">
                  <label class="control-label file optional" for="article_eyecache">アイキャッチ</label>
                  <input class="file optional" type="file" name="eyecache" id="article_eyecache" />
                </div>
                <!-- <input type="hidden" name="article[eyecatch_align]" value="" /> -->
                <span class="radio radio radio">
                  <label for="article_eyecatch_align_left">
                    <input class="enum_radio_buttons optional" type="radio" value="0" name="eyecatch_align" id="article_eyecatch_align_left"
                    @if($article->eyecatch_align == 0) checked
                    @endif
                    />左寄せ
                  </label>
                </span>
                <span class="radio radio radio">
                  <label for="article_eyecatch_align_center">
                    <input class="enum_radio_buttons optional" type="radio" value="1" name="eyecatch_align" id="article_eyecatch_align_center"
                    @if($article->eyecatch_align == 1) checked
                    @endif
                    />中央
                  </label>
                </span>
                <span class="radio radio radio">
                  <label for="article_eyecatch_align_right">
                    <input class="enum_radio_buttons optional" type="radio" value="2" name="eyecatch_align" id="article_eyecatch_align_right"
                    @if($article->eyecatch_align == 2) checked
                    @endif
                    />右寄せ
                  </label>
                </span>
                <div class="form-group integer optional article_eyecatch_width">
                  <label class="control-label integer optional" for="article_eyecatch_width">横幅</label>
                  <input class="form-control numeric integer optional" placeholder="100" type="number" value="{{ $article->eyecatch_width }}" name="eyecatch_width" id="article_eyecatch_width" />
                </div>
                <div class="form-group text optional article_description">
                  <label class="control-label text optional" for="article_description">概要</label>
                  <textarea class="form-control text optional js-autosize" name="description" id="article_description">{{ $article->description }}</textarea>
                </div>
                <div class="form-group select2 optional article_author_id">
                  <label class="control-label select2 optional" for="article_author_id">著者</label>
                  <select class="select2 optional form-control js-select2" name="author_id" id="article_author_id">
                    <option value=""></option>
                    @foreach($authors as $author)
                    <option value="{{ $author->id }}"
                      @if($article->author_id == $author->id) selected
                      @endif
                    >{{ $author->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group select2 optional article_category_id">
                  <label class="control-label select2 optional" for="article_category_id">カテゴリー</label>
                  <select class="select2 optional form-control js-select2" name="category_id" id="article_category_id">
                    <option value=""></option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                      @if($article->category_id == $category->id) selected
                      @endif
                    >{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group select2 optional article_tag_ids">
                  <label class="control-label select2 optional" for="article_tag_ids">タグ</label>
                  <select multiple="multiple" class="select2 optional form-control js-select2" name="tag_ids[]" id="article_tag_ids">
                    @foreach($tags as $tag)
                    <option value="{{ $tag->id }}"
                      @if(in_array($tag->id, $choosedTags)) selected
                      @endif
                    >{{ $tag->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="box-footer"><input type="submit" name="commit" value="更新する" class="btn btn-primary" data-disable-with="更新する" /></div>
            </form>
          </div>
          <div class="box box-solid box-info">
            <div class="box-header">
              <h3 class="box-title">公開</h3>
            </div>
            <div class="box-body"><a class="btn btn-default btn-block btn-flat" target="_blank" href="/admin/articles/70fd2f30-2f21-4729-a49f-a4e7c3b4f3eb/preview"><i class="fa fa-eye"></i> プレビュー</a></div>
            <div class="box-footer"><a class="btn btn-success btn-block btn-flat" rel="nofollow" data-method="patch" href="{{ route('admin.articles.publish', $article->id) }}"><i class="fa fa-send"></i> 公開する</a></div>
          </div>
        </div>
      </div>
    </form>
  </section>

  <script type="text/javascript">
  var i = $("#php_idx").val();
  var idx = '000';
  $(document).on('click', '#add-btn', function()
  {
    ++i;
    idx = ('000' + i).slice(-3);
    $("#dynamicAddRemove").append('<tr><td><trix-editor class="trix-content" input="x'+idx+'"></trix-editor><input id="x'+idx+'" type="hidden" name="body'+idx+'"></td><td><button type="button" class="btn btn-danger remove-tr">削除</button></td></tr>');
  });
  $(document).on('click', '.remove-tr', function()
  {
    $(this).parents('tr').remove();
  });
  </script>

@stop
