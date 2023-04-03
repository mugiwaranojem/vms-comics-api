<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Contracts\ApiInterface;
use Illuminate\Http\Client\Response;

class MarvelApiService implements ApiInterface
{
	private const CREATORS_PATH = 'creators';
	private const LIMIT = 10;

	private int $limit;

	public function buildUrl(string $path = '/'): string
	{
		$hashParam = md5(sprintf(
			'1%s%s',
			env('MARVEL_PRIVATE_API_KEY'),
			env('MARVEL_PUBLIC_API_KEY'),
		));
		$authParam = sprintf(
			'?ts=1&apikey=%s&hash=%s',
			env('MARVEL_PUBLIC_API_KEY'),
			$hashParam
		);
		$limit = $this->limit ?? self::LIMIT;

		return sprintf(
			'%s/%s%s%s',
			env('MARVEL_API_URL',''),
			$path,
			$authParam,
			'&limit='.$limit
		);
	}

	public function setLimit(int $limit): void
	{
		$this->limit = $limit;
	}

	public function getCreators(): Response
	{
		$url = $this->buildUrl(self::CREATORS_PATH);
		return Http::get($url);
	}

	/**
	* @param int $id - Creator id
	*/
	public function getCreatorComics(int $id): Response
	{
		$url = $this->buildUrl(self::CREATORS_PATH.'/'.$id.'/comics');
		return Http::get($url);
	}
}