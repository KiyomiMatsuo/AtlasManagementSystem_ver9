<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    //多対多のリレーション定義（ユーザー側）
    //belongsToMany( 相手のモデル名 , 中間テーブルのテーブル名 , 自分のidが入るカラム名 , 相手のidが入るカラム名)
    public function users(){
        return $this->belongsToMany('App\User','subject_users','subject_id','user_id');// リレーションの定義
    }
}
