<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'thumbnail_url',
        'external_id'
    ];

    public function comics()
    {
        return $this->belongsToMany(Comic::class, 'author_comics', 'author_id', 'comic_id');
    }
}