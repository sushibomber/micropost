<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{

    public function store(Request $request, $id)
    {
        \Auth::user()->follow($id);     // \Auth::user()・・・・ログインしているユーザーのインスタンスを取得。ログインユーザー一覧を出すという意味ではない。（$id）にはfollow_button.blade.phpの$user->idが入る。
        return back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfollow($id);    //follow_button.blade.phpから飛ばされてくる。ログインしているユーザー（自身）がアンフォローしたidを削除
        return back();
    }
}
