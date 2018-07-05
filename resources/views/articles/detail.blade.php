@extends('app')
@section('content')
    <h1>{{$article->title}}</h1>
    <hr>
    <a class="btn btn-primary" href="{{route('article.edit',['id'=>$article->id])}}">编辑文章</a>
    <a class="btn btn-primary" href="{{route('article.delete',['id'=>$article->id])}}">删除文章</a>
    <hr>
    <article>
        <div class="markdown-body" id="content">
            {!!$article->content!!}
        </div>
    </article>
@endsection
@section('footer')
    <script>
        // $(function () {});
    </script>
@endsection
