<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category'
    ];

    public function subCategories(){
        // リレーションの定義
        //「１対多」の「多」側 → メソッド名は複数形でhasManyを使う
        return $this->hasMany('App\Models\Categories\subCategory');
    }

}
