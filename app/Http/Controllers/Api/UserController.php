<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function changeAvatar(Request $request)
    {
        try {
            $dataUrl = $request->input('dataUrl');
            $destinationPath = 'uploads/';

            preg_match('/^(data:\s*image\/(\w+);base64,)/', $dataUrl, $result);
            $type = $result[2];

            $img = Image::make($dataUrl)->fit(200);

            // 将处理后的图片重新保存到其他路径
            $fileName = $destinationPath . Auth::id() . '_' . time() . '.' . $type;
            $img->save($fileName);

            $user = Auth::user();
            $user->avatar = env('APP_URL').'/'.$fileName;
            $user->save();
            return apiSuccess();
        } catch (\Exception $e) {
            return apiError($e->getMessage());
        }
    }


}
