<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Storage;
use Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\Post as PostResourse;
use App\Http\Resources\PostShow as PostShowResourse;

class PostController extends Controller
{
    public function top()
    {
        try{
            $feeRank=Post::select(DB::raw('user_id,SUM(fee) as total_fee,name'))->join('users','users.id','=','posts.user_id')->groupBy('user_id')->orderBy('total_fee','desc')->get();
            $posts = Post::latestFirst()->take(3)->get();
            return response()->json(['feeRank'=>$feeRank,'posts'=>$posts]);
        }catch ( Exception $ex ){
            // LogUtil::logError ( Const::DEF_LOG_DATABASE, $ex->getMessage () );
            return response()->json($ex->getMessage ());
        }
        
    }
    public function store(PostStoreRequest $request)
    {
        //get all
        $params = $request->json()->all();

        //image
        list(, $image) = explode(';', $params['image']);
        list(, $image) = explode(',', $image);
        $decodedImage = base64_decode($image);

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
    public function index()
    {
        $posts = Post::latestFirst()->paginate(8);
        return PostResourse::collection($posts);
    }

    public function show(Request $request) {
		return new PostShowResourse(Post::find($request->id));
    }

    public function destroy(Post $post,Request $request){
        $post=Post::find($request->id);
        $this->authorize('destroy',$post);
        $post->delete();
        return response(null,204);   
    }
}
