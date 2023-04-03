<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\AuthorRepository;

class AuthorController extends BaseController
{
	private AuthorRepository $authorRepository;

	public function __construct(
		AuthorRepository $authorRepository
	) {
		$this->authorRepository = $authorRepository;
	}

    // use AuthorizesRequests, ValidatesRequests;
	public function index(Request $request)
    {
        $results = $this->authorRepository->all();
        return response()->json($results);
    }

    public function authorComics(Request $request, int $id)
    {
    	$results = $this->authorRepository->getAuthorComics($id);
    	return response()->json($results);
    }
}
