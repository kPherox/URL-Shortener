<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    //
    protected $table = 'short_urls';

    public $timestamps = true;

    protected $fillable = ['short_url', 'long_url', 'url_name', 'registed', 'user_id'];

    protected $guarded = [];

}
