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

    public function scopeOfLongUrlAndUserId($query, $longUrl, $userId)
    {
        return $query->where('long_url', $longUrl)
            ->where('user_id', $userId);
    }

    public function scopeOfShortUrl($query, $shortUrl)
    {
        return $query->where('short_url', $shortUrl);
    }
}
