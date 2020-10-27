<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Storage;
use Str;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function store(Request $request)
    {
        //get all
        $params = $request->json()->all();

        //image
        list(, $image) = explode(';', $params['image']);
        list(, $image) = explode(',', $image);
        $decodedImage = base64_decode($image);

        // $user_id = $params['user_id'];
        $user_id = $request->user()->id;
        $message = $params['message'];
        $area = $params['area'];
        $transport = $params['transport'];
        $count = $params['count'];
        $fee = $params['fee'];
        $start_hour = $params['start_hour'];
        $start_min = $params['start_min'];
        $end_hour = $params['end_hour'];
        $end_min = $params['end_min'];

        //トランザクション処理
        DB::transaction(function () use ($decodedImage, $user_id, $message, $area, $transport, $count, $fee, $start_hour,$start_min, $end_hour,$end_min) {
            $id = Str::uuid();
            $file = $id->toString();

            Post::create([
                'user_id' => $user_id,
                'img_path' => $file,
                'area' => $area,
                'message' => $message,
                'count' => $count,
                'fee' => $fee,
                'transport' => $transport,
                'start_hour' => $start_hour,
                'start_min' => $start_min,
                'end_hour' => $end_hour,
                'end_min' => $end_min
            ]);

            // S3 post/aaa.jpg
            $isSuccess = Storage::disk('s3')->put('post/'.$file, $decodedImage);
            if (!$isSuccess) {
                throw new Exception('ファイルのアップでエラー');
            }
            Storage::disk('s3')->setVisibility('post/'.$file,'public');

            // return $id;
        });
        return response('success');
    } 
}
