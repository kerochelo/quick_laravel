<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} | {{ $site->name }}</title>
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
    </header>
    <section class="container page-content">
      <main>
        <div class="container article-content">
          <h1 class="title">{{ $article->title }}</h1>
          @if($article->published_at)
          <section class="published-at"><time>{{ $article->published_at->format('Y 年 m 月 d 日') }}</time></section>
          @endif
          <section class="category">
            <h4>Category</h4>
            @if($category)
            <a href="{{ route('blogs.category.index', $category) }}">{{ $category->name }}</a>
            @endif
          </section>
          <article class="article">
          {!! $article->body !!}
          </article>
          <section class="row next-article my-5">
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  <h6 class="card-title text-center">古い記事</h6>
                  <h6 class="card-title"><a href="/test-category/test-post">テスト記事</a></h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6"></div>
          </section>
        </div>
      </main>
      <div class="section container new_arrivals my-5">
        <h3 class="text-center mb-5">新着記事</h3>
          <div class="card-deck">
              @foreach ($new_articles as $article)
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
                  @if($article->published_at)
                  <p class="card-text"><small class="text-muted">{{ $article->published_at->format('Y 年 m 月 d 日') }}</small></p>
                  @endif
                </div>
              </div>
              @endforeach
          </div>
        </div>
      </div>
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
