<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Picture;

use Illuminate\Support\Facades\Storage;


class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];    //空の配列を初期化
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
        
            $microposts_id = $user->feed_microposts()->pluck('microposts.id')->toArray();
            
    
            $pictures = Picture::whereIn('micropost_id', $microposts_id);  //pictureテーブルのmicropost_idと$microposts_idのidが一致しているもの（画像の投稿があるもの）が$picturesに入る
            
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
                'pictures' => $pictures,
            ];
            
            $data += $this->counts($user);
        }
        
        return view('welcome', $data);
    }
    
    
    public function store(Request $request)    //welcome.blade.phpから、postと画像が送られてくる　→　$requestの中に入れられる
    {
       
       
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);


        //micropostsテーブルの中にあるcontentカラムに、$request->contentの情報に入れる。micropostsテーブルにcontentカラムがある必要がある。
        //$request->user()->microposts()　・・・　間にuser()を挟むのは、ユーザーテーブルの内容もDBに保存する必要があるから。
        //'content' => $request->content,　・・・　'content'に$request->contentの内容を入れる
        //micropostsテーブルの中のcontentカラムに、$request->contentの内容を保存する
        //createでDBへの保存を行う。
         $data = $request->user()->microposts()->create([ 
            'content' => $request->content,
          
        ]);
        
        
        
        //直前のmicropostsのidを取得（直前をどうｺｰﾃﾞｨﾝｸﾞすればよいかを考える）
        //ファイル名とmicropsts_idを連結(contentの中にmicroposts_idが入っている)
        $micropost_id = $data->id;
        
        
        if($request->image != null){
        
            $file_name =  $micropost_id . "-" . $request->file('image')->getClientOriginalName();
            //"-"　・・・　micropost_id - オリジナルファイル名　というファイル名で保存するため
        
            $picture = new Picture();
            $picture->create([
                'micropost_id' => $micropost_id,
                'img_path' => $file_name,
            ]);
            //pictureテーブルのimg_pathカラムに$file_nameを保存する
            //picturesのmicropost_idとmicropostsテーブルのidを紐づける必要がある
            $request->file('image')->storeAS('public/', $file_name );    //ディレクトリに保存する処理。

        } 

        return back();
    }
    
    
    

    
    public function destroy($id) //'micropost_id'はpicturesテーブルのmicropost_idカラム　$idはmicropostテーブルのidカラム
    {
        $micropost = \App\Micropost::find($id);
        
        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
    
            $picture = Picture::where('micropost_id', $id);
            
            //dd($picture->get()[0]->micropost_id);
            
            //$file_name = $picture->get()[0]->img_path;            
            
            if( isset($picture->get()[0]) ){
                
                $file_name = $picture->get()[0]->img_path;
                $picture->delete();
                Storage::delete('public/' . $file_name);       
     
            }
        
        }

        return back();
    }
    
    
}