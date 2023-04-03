<?php   

namespace App\Repositories;

use App\Models\Comic;

class ComicRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Comic);
    }
}