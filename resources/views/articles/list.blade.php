@extends('app')
@section('content')
    <h1>Articles</h1>
    <hr>
    <div class="panel-body">
        <a href="{{route('article.create')}}" class="btn btn-primary">新建文章</a>
    </div>
    <hr>
    <div>
        <ul class="list-group">
            @foreach($articles as $article)
                <li class="list-group-item">
                    <a href={{"/article/".$article->id}}>{{$article->title}}</a>
                    <article>
                        <div class="body">
                            {{$article->content}}
                        </div>
                    </article>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
@section('footer')
    <script>
    </script>
@endsection