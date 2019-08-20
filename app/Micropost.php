<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class); //belongsToでuserモデルclassの呼び出し。micropostクラスと、userクラスを紐づけている。
    }
    
    public function picture()
    {
        return $this->hasOne(Picture::class);  //micropostクラスとpictureクラスを紐づける。
    }
}