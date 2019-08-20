<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class); // UserclassとMicropostclassが一対多で紐付く
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
        
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }    
    
    public function follow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
    
        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    
    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();  //userがフォローしているuserのidカラム（userテーブルのidカラム）を取得し配列に変換
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);  //micropostテーブルのuser_idカラムと、$follow_user_idsのidが一致しているデータを、micropostインスタンスとして返す
    }
    
    
    //favoritesの定義　favoritesとfavoriteで分けているのは一緒にするとわかりにくいためで、PC側は一緒にしても問題ない
    public function favorites()
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();    //Micropostのインスタンスを取得したいのでMicropost::class
    }    
    
    
    //favoriteの定義
    public function favorite($micropost_id)
    {
         $exist = $this->add_favorites($micropost_id);
         $its_me = $this->id == $micropost_id;
        
        if($exist || $its_me) {
            return false;    
        } else {
            $this->favorites()->attach($micropost_id);    
            return true;
    }
   }
   
   
   //add_favoritesの定義
   public function add_favorites($micropost_id)
   {

        return $this->favorites()->where('micropost_id' , $micropost_id)->exists();  //$thisはuserインスタンスを意味する（自分に限らず全ユーザー） ログイン中のユーザーがお気に入りにした投稿の中で、'microposts_id'カラム（DBの話）の中に$microposts_idが存在するかどうかを確認している
   }  //->exists();があるためtrueかfalseを返すことになる
   
    
    //unfavoriteの定義
    public function unfavorite($micropost_id)
    {
        $exist = $this->add_favorites($micropost_id);
        $its_me = $this->id == $micropost_id;
        
        
        
        //$exist:既にお気に入りに追加しているか　$its_me:投稿が自分自身のものかどうか　両方true（！論理否定を含めて）であればお気に入りから外される。
        //&&はand　！は論理演算子の論理否定（$○○の中身を逆にする・・・trueであればfalseにする）
        if($exist && !$its_me) {
            $this->favorites()->detach($micropost_id);
            return true;
        }else{
            return false;
        }
    }

    
}