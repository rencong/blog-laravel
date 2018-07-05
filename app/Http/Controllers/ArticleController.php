<?php

namespace App\Http\Controllers;

use App\Markdown\Markdown;
use App\Model\Article;
use App\Model\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::latest()->published()->get();//倒叙排列
        return view('articles.list', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $article->content = app(Markdown::class)->markdown($article->content);
        return view('articles.detail', compact('article'));
    }

    public function create()
    {
        $category = ArticleCategory::all();
        return view('articles.create', compact('category'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $category = ArticleCategory::all();
        return view('articles.edit', compact('article', 'category'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id'           => 'required',
            'title'        => 'required|string',
            'content'      => 'required|string',
            'published_at' => 'required',
            'category'     => 'sometimes'
        ]);
        $article = Article::findOrFail($request->input('id'));
        $input = $request->all();
        unset($input['id']);
        $article->update($input);
        return redirect('/article/list');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'title'        => 'required|string',
            'content'      => 'required|string',
            'published_at' => 'required',
            'category'     => 'sometimes'
        ]);
        $input = $request->all();
        Article::create($input);//自动过滤token
//        Article::create(array_merge($input, ['user_id' => Auth::user()->id]));//自动过滤token
        return redirect('/article/list');
    }

    public function delete($id)
    {
        Article::find($id)->delete();
        return redirect('/article/list');
    }

    public function transformCollection($articles)
    {
        return array_map([ArticleController::class, 'transform'], $articles->toArray());
    }

    static function transform($article)
    {
        return [
            'id'      => $article['id'],
            'title'   => $article['title'],
            'content' => $article['content']
        ];
    }

}
