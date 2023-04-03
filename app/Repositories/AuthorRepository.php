<?php   

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Author);
    }

    public function getAuthorComics(int $id)
    {
    	return $this->find($id)->comics;
    }
}