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
        return $query->ofUserId($userId)->ofLongUrl($longUrl);
    }

    public function scopeOfShortUrl($query, $shortUrl)
    {
        return $query->where('short_url', $shortUrl);
    }

    public function scopeOfLongUrl($query, $longUrl)
    {
        return $query->where('long_url', $longUrl);
    }

    public function scopeOfUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function longUrlExists($longUrl, $userId)
    {
        $shortUrls = self::ofLongUrlAndUserId($longUrl, $userId);
        return $shortUrls->exists();
    }

    public function getShortUrl($longUrl, $userId)
    {
        $shortUrls = self::ofLongUrlAndUserId($longUrl, $userId)->first();
        return $shortUrls->short_url;
    }
}
