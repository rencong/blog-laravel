<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Markdown\Markdown;
use App\Model\Article;
use App\Model\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ArticleController extends Controller
{
    public function apiUserInfo(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
            if ($user) {
                return apiSuccess($user->id);
            } else {
                return apiError('用户没有登录');
            }
        } catch (\Exception $e) {
            return apiError($e->getMessage());
        }
    }

    public function apiList(Request $request)
    {
        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $articles = Article::where('title', 'like', "%{$keyword}%")->with('user')->latest()->paginate(10);
        } else {
            $articles = Article::with('user')->latest()->paginate(10);
        }
        return apiSuccess($articles);
    }

    public function apiUserList(Request $request)
    {
        $user_id = $request->input('user_id');
        $articles = Article::where('user_id', $user_id)->latest()->paginate(10);
        return apiSuccess($articles);
    }

    public function apiEdit(Request $request)
    {
        $id = $request->input('id');
        if ($id !== null) {
            $article = Article::find($id);
        }
        $category = ArticleCategory::all();

        return Response::json([
            'status'   => 'success',
            'code'     => 200,
            'category' => $category,
            'article'  => (isset($article) && $article) ? $article : null
        ]);
    }

    public function apiSave(Request $request)
    {
        try {
            $this->validate($request, [
                'title'        => 'required|string',
                'content'      => 'required|string',
                'published_at' => 'required',
                'category'     => 'sometimes',
                'id'           => 'sometimes'
            ]);
            $id = $request->input('id');
            if ($id != '') {
                $article = Article::findOrFail($id);
                $input = $request->all();
                unset($input['id']);
                $article->update($input);
            } else {
                $input = $request->all();
                $input['user_id'] = Auth::guard('api')->user()->id;
                Article::create($input);//自动过滤token
            }
            return apiSuccess();
        } catch (\Exception $e) {
            return apiError($e->getMessage());
        }
    }

    public function apiShow(Request $request)
    {
        $id = $request->input('id');
        $article = Article::find($id);
        if (!$article) {
            return apiError('Article not found');
        }
        $article->content = app(Markdown::class)->markdown($article->content);

        return apiSuccess($article);
    }

    public function apiDelete(Request $request)
    {
        try {
            Article::find($request->input('id'))->delete();
            return apiSuccess();
        } catch (\Exception $e) {
            return apiError($e->getMessage());
        }
    }
}
