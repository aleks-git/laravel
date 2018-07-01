<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'full_img',
        'preview_img',
        'staff_id'
    ];


}
