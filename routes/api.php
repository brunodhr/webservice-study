<?php

use Illuminate\Http\Request;
use App\User;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/cadastro',function (Request $request){
    $data = $request->all();
    $validacao = Validator::make($data, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if($validacao->fails()){
        return $validacao->errors();
    }
    
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);
    $user->token= $user->createToken($user->email)->accessToken;

    return $user;
});

Route::post('/publicar',function (Request $request){
    $data = $request->all();
    $validacao = Validator::make($data, [
        'content' => 'required|string',
    ]);

    if($validacao->fails()){
        return $validacao->errors();
    }
    
    $post = Post::create([
        'content' => $data['content']
    ]);

    return $post;
});

Route::post('/login',function (Request $request){
    $data = $request->all();

    $validacao = Validator::make($data, [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string',
    ]);

    if($validacao->fails()){
        return $validacao->errors();
    }
    
    if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
        $user = auth()->user();
        $user->token= $user->createToken($user->email)->accessToken;
        return $user;
    }else{
        return ['status'=>false];
    }
});

Route::middleware('auth:api')->get('/usuario', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->put('/perfil', function (Request $request) {
    $user = $request->user();
    $data = $request->all();
    return $data;
});
