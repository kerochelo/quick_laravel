<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site->name }}</title>
    <!-- Styles -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" />
  </head>
  <body class="antialiased">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ __($error) }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <header>
      <div class="swiper-container">
        <div class="swiper-wrapper">
          @if($site->main_image)
          <img class="swiper-slide" src="{{ asset('storage/main_image/' . $site->main_image) }}" />
          @endif
        </div>
      </div>
      <div class="container blog-title">
        <h1><a href="/blogs/">{{ $site->name }}</a></h1>
        @if($site->subtitle)
        <p class="lead">{{ $site->subtitle }}</p>
        @endif
      </div>
    </header>
    <section class="container page-content">
      <main>
        <div class="card-columns">
          @foreach ($articles as $article)
          <div class="card">
            <div class="card-body">
              <p class="card-link">
                @foreach($categories as $category)
                @if ($category->id == $article->category_id)
                <a href="{{ route('blogs.category.index', $category) }}">{{ $category->name }}</a>
                @endif
                @endforeach
              </p>
              <h5 class="card-title"><a href="{{ route('blogs.show', $article) }}">{{ $article->title }}</a></h5>
              <p class="card-text"><small class="text-muted">{{ $article->published_at->format('Y 年 m 月 d 日') }}</small></p>
            </div>
          </div>
          @endforeach
        </div>
      </main>
      <div class="section container categories my-5">
        <h3 class="text-center mb-5">カテゴリ</h3>
        <div class="d-flex justify-content-between">
          @foreach($categories as $category)
          <a class="btn btn-link btn-lg btn-outline-primary" href="{{ route('blogs.category.index', $category) }}">{{ $category->name }}</a>
          @endforeach
        </div>
      </div>
    </section>
  </body>
</html>
