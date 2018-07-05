@extends('app')
@section('content')
    <h1>编辑文章</h1>
    <form action="{{route('article.update')}}" method="post">
        {{csrf_field()}}
        <input hidden name="id" value="{{$article->id}}">
        <div class="form-group">
            <label>Title</label>
            <input class="form-control" name="title" value="{{$article->title}}">
        </div>
        <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="category">
                <option value="">空</option>
                @foreach($category as $item)
                    @if($item->title == $article->category)
                        <option value="{{$item->title}}" selected>{{$item->title}}</option>
                    @else
                        <option value="{{$item->title}}">{{$item->title}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea id="markdownEdit" class="form-control" name="content">{{$article->content}}</textarea>
        </div>
        <div class="form-group">
            <label>Published_at</label>
            <input type="date" name="published_at" class="form-control"
                   value="{{date('Y-m-d',strtotime($article->published_at))}}">
        </div>
        <button type="submit" class="btn btn-primary form-control">保存</button>
    </form>
@endsection
@section('footer')
    <script>
        var simplemde = new SimpleMDE({
            autoDownloadFontAwesome: false,
            element: document.getElementById("markdownEdit"),
            status: false,
            forceSync: true,
            showIcons: ["code", "table"],
            tabSize: 4,
            promptURLs: true,
            renderingConfig: {
                codeSyntaxHighlighting: true
            },
            toolbar: ["bold", "italic", "|", 'link', "quote", "code", 'image', "|", 'unordered-list', 'ordered-list', "|", 'clean-block', 'table'
                , 'horizontal-rule', 'preview', 'side-by-side', 'fullscreen', "strikethrough", "heading", 'heading-smaller', 'heading-bigger',
                // 'heading-1', 'heading-2', 'heading-3',
                'guide',
                {
                    name: 'title1',
                    action: function customFunction(editor) {
                        var cm = editor.codemirror;
                        _toggleHeading(cm, "title", 1);
                    },
                    className: 'glyphicon glyphicon-align-left',
                    title: 'title1'
                },
                {
                    name: 'title2',
                    action: function customFunction(editor) {
                        var cm = editor.codemirror;
                        _toggleHeading(cm, "title", 2);
                    },
                    className: 'glyphicon glyphicon-align-left',
                    title: 'title2'
                },
            ]
        });

        function _toggleHeading(cm, direction, size) {
            if (/editor-preview-active/.test(cm.getWrapperElement().lastChild.className))
                return;

            var startPoint = cm.getCursor("start");
            var endPoint = cm.getCursor("end");
            var textNew = '';
            for (var i = startPoint.line; i <= endPoint.line; i++) {
                (function (i) {
                    var text = cm.getLine(i);
                    textNew += text;
                })(i);
            }
            if (size === 1) {
                textNew === '' ? textNew = "标题文字\n====" : textNew += "\n====";
            } else if (size === 2) {
                textNew === '' ? textNew = "标题文字\n----" : textNew += "\n----";
            }
            cm.replaceSelection(textNew);
            cm.focus();
        }

        $(".editor-preview-side").addClass("markdown-body");
    </script>
@endsection
