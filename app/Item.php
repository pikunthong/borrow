<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    //
    use SoftDeletes;//จะไม่ลบจริงๆข้อมูลจะไม่หายจาก database
    protected $fillable = [
        'title','detail','image','status'
    ];
}
