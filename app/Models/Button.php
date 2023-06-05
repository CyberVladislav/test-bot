<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    public const TYPE_URL = 1;
    public const TYPE_CALLABLE = 2;

    protected $fillable = [
        'title',
        'priority',
        'callback_data',
        'url',
        'url_button_text',
    ];
}
