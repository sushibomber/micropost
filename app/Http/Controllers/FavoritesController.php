<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User; // 追加
use App\Micropost; // 追加



class FavoritesController extends Controller
{
    public function store(Request $request, $id)
    {
        \Auth::user()->favorite($id);    //ログインユーザー（自身）がお気に入りにしたmicropostsのidを保存　micropostsのidである理由は、User.php参照
        return back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    
    }
    
    public function get_favorites($id) //favoriteに追加した'投稿の一覧'を表示するための機能　web.phpでFavoritesController@get_favoritesに飛ばすコードあり。
    {
        //userscontrollerを参考にする
        
            
        $user = User::find($id);  //DBから対象のidを見つけ出す　左記のコードでそのidのユーザーの情報をすべて取得できるようになる（別途コード追記の必要あり）
        
        $users = User::all(); //allは引数を渡してはいけない
        
        $favorites = $user->favorites()->orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
            'user' => $user,
            'microposts' => $favorites,
            
        ];
        
        //$favoritesの中身は、$user_id $microposts_idが入っている　キーの名前をmicropostsにしている
        
        
        
        $data += $this->counts($user);
        
        return view('users.favorites' ,  $data);
        
    }
    
}