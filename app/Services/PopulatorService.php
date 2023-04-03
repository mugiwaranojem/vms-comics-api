<?php

namespace App\Services;

use App\Contracts\PopulatorInterface;
use App\Contracts\ApiInterface;
use App\Models\{Author, Comic, AuthorComic};
use Illuminate\Http\Client\Response;
use App\Repositories\{ComicRepository, AuthorRepository, AuthorComicRepository};

class PopulatorService implements PopulatorInterface
{
	/**
	* @var ApiInterface $apiService
	*/
	private ApiInterface $apiService;

	/**
	* @var AuthorRepository $authorRepository
	*/
	private AuthorRepository $authorRepository;

	/**
	* @var ComicRepository $comicRepository
	*/
	private ComicRepository $comicRepository;

	/**
	* @var AuthorComicRepository $authorComicRepository
	*/
	private AuthorComicRepository $authorComicRepository;

	public function __construct(
        ApiInterface $apiService,
        ComicRepository $comicRepository,
        AuthorRepository $authorRepository,
        AuthorComicRepository $authorComicRepository
    ) {
        $this->apiService = $apiService;
        $this->authorRepository = $authorRepository;
        $this->comicRepository = $comicRepository;
        $this->authorComicRepository = $authorComicRepository;
    }

	public function populate(): void
	{
		$response = $this->apiService->getCreators();
		$creators = $this->getDataResults($response);

		foreach ($creators as $key => $creator) {
			$this->saveData($creator);
		}

	}

	private function saveData(array $data): void
	{
		// Skip if data exist
		if ($this->authorRepository->findWhereFirst(['external_id', $data['id']])) {
			return;
		}

		$thumbnail = $data['thumbnail']
			? $data['thumbnail']['path'] .'.'. $data['thumbnail']['extension']
			: '';
		$authorPayload = [
			'external_id' => $data['id'] ?? '',
			'last_name' => $data['lastName'] ?? '',
			'first_name' => $data['firstName'] ?? '',
			'thumbnail_url' => $thumbnail,
		];

		$author = $this->authorRepository->create($authorPayload);
		if (!$author) {
			return;
		}

		$response = $this->apiService->getCreatorComics($author->external_id);
		$comics = $this->getDataResults($response);

		foreach ($comics as $comic) {
			// Comic
			$thumbnail = $data['thumbnail']
				? $data['thumbnail']['path'] .'.'. $data['thumbnail']['extension']
				: '';
			$comicPayload = [
				'external_id' => $comic['id'] ?? null,
				'title' => $comic['title'] ?? '',
				'series_name' => $comic['series']['name'] ?? '',
				'description' => $comic['description'] ?? '',
				'page_count' => $comic['pageCount'] ?? 0,
				'thumbnail_url' => $thumbnail
			];
			$comicModel = $this->comicRepository->create($comicPayload);

			// Author Comic relation
			$this->authorComicRepository->create([
				'author_id' => $author->id,
				'comic_id' => $comicModel->id
			]);
		}

	}

	private function getDataResults(Response $response)
	{
		$data = $response->json();
		$responseStatus = $data['status'] ?? false;
		$data = $data['data'] ?? false;

		if ($responseStatus && strtolower($responseStatus) !== 'ok') {
			// TODO: ApiException
		}

		if (!$data) {
			// TODO: ApiException
		}

		$results = $data['results'] ?? [];
		if (empty($results)) {
			// TODO: ApiException
		}

		return $results;
	}
}