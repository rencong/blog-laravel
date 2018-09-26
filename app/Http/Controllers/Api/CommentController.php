<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function apiSave(Request $request)
    {
        try {
            $this->validate($request, [
                'article_id' => 'required|exists:articles,id',
                'body'       => 'required|string',
            ]);
            Comment::create(array_merge($request->all(), ['user_id' => Auth::id()]));
            return apiSuccess();
        } catch (\Exception $e) {
            return apiError($e->getMessage());
        }
    }


}
