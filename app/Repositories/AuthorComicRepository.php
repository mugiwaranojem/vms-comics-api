<?php   

namespace App\Repositories;

use App\Models\AuthorComic;

class AuthorComicRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new AuthorComic);
    }
}