<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\DB;
use Str;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request){
        
        $user = User::create([
            'email'=> $request->email,
            'name'=> $request->name,
            'password'=> bcrypt($request->password),
            'twitter_id' => $request->twitter_id,
            'img_path'=> $request->img_path,
            'transport' => $request->transport
        ]);

        if(!$token = auth()->attempt($request->only(['email','password']))){
            return abort(401);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' =>$token,
            ]
        ]);
    }
    public function login(UserLoginRequest $request){

        if(!$token = auth()->attempt($request->only(['email','password']))){
            return response()->json([
                'errors' =>[
                    'email'=>['一致しませんでした。']
                ]
            ],422);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' =>$token,
            ]
        ]);
    }

    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(UserEditRequest $request){
        // return $request;
        $image = $request->image;
        // if profileimage
        if ($image) {
            list(, $file) = explode(';', $image);
            list(, $file) = explode(',', $file);
            $decodedImage = base64_decode($file);
        } else {
            $decodedImage = false;
        }

        //find user
        $email = $request->email;
        $name = $request->name;
        $password = $request->password;
        $twitter_id = $request->twitter_id;
        $image = $request->file('image');
        $transport = $request->transport;

        $user_id = $request->user()->id;

        //transaction
        DB::transaction(function () use ($decodedImage,$user_id,$name,$email,$password,$twitter_id,$transport,$image) {
            $user = User::find($user_id);
        
            // if profile_image
            if (!is_null($decodedImage)){
                $id = Str::uuid();
                $img_path = $id->toString();
                //s3にファイルがあるか？(dbで判定)y->delete->upload,n->upload
                if (!is_null($user->img_path)) {
                    //delete old img
                    Storage::disk('s3')->delete('profile/' . $user->img_path);
                } 
                //upload
                $isSuccess = Storage::disk('s3')->put('profile/'.$img_path, $decodedImage);
                if (!$isSuccess) {
                    throw new Exception('ファイルのアップでエラー');
                }
                //publicにする
                Storage::disk('s3')->setVisibility('profile/'.$img_path, 'public');
            }else{
                $img_path =null;
            }

            //update
            $user->update(
                [
                    'email'=> $email,
                    'name'=> $name,
                    'password'=> bcrypt($password),
                    'twitter_id' => $twitter_id,
                    'img_path'=> $img_path,
                    'transport' => $transport
                ]
            );
            return response(null,204);
        });
             
        
        //認証成功でtrue
        if (!$token = auth()->attempt($request->only(['email','password']))){
            return abort(401);
        }

        return (new UserResource($request->user()))->additional([
            'meta' => [
                'token' =>$token,
            ]
        ]);
    }

    public function logout()
    {
        auth()->logout();
    }
}
