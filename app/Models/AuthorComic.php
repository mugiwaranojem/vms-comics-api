<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorComic extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_id',
        'comic_id',
    ];
}