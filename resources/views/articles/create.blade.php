@extends('app')
@section('content')
    <h1>创建新文章</h1>
    {{--<form id='form' action="{{route('article.save')}}" method="post">--}}
        {{--{{csrf_field()}}--}}
        <div class="form-group">
            <label>Title</label>
            <input class="form-control" name="title">
        </div>
        <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="category">
                <option value="空">空</option>
                @foreach($category as $item)
                    <option value="{{$item->title}}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea id="markdownCreate" class="form-control" name="content"></textarea>
        </div>
        <button onclick="cong()">33</button>
        <div class="form-group">
            <label>Published_at</label>
            <input type="date" id="published_at" name="published_at" class="form-control" value="{{date('Y-m-d')}}">
        </div>
        {{--<button type="submit" class="btn btn-primary form-control">发表文章</button>--}}
    {{--</form>--}}
@endsection
@section('footer')
    <script>
        function cong() {
            console.log($('#published_at').val())
        }
        var simplemde = new SimpleMDE({
            autoDownloadFontAwesome: false,
            element: document.getElementById("markdownCreate"),
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
        $(".editor-preview-side").addClass("markdown-body");

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
    </script>
@endsection
