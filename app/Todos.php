<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todos extends Model
{
    protected $guarded = array('id');
    //
    public static $rules = array(
        'title' => 'required',
        // 'date' => 'required',
    );

    // Todosモデルに関連付けを行う
    public function histories()
    {
        return $this->hasMany('App\History');
    }
}
