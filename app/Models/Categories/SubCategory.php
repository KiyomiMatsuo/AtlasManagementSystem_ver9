<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
    public function mainCategory(){
        // リレーションの定義
        //「１対多」の「1」側 → メソッド名は単数形でbelongsToを使う
        return $this->belongsTo('App\Models\Categories\mainCategory');
    }

    public function posts(){
        // リレーションの定義
        //belongsToMany( 相手のモデル名 , 中間テーブルのテーブル名 , 自分のidが入るカラム名 , 相手のidが入るカラム名)
        return $this->belongsToMany('App\Models\Posts\Post','post_sub_categories','sub_category_id','post_id') ;
    }
}
