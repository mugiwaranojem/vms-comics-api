<?php
namespace App\Contracts;

/**
 * Describes Api Class.
 */
interface ApiInterface
{
    public function buildUrl(string $path = '/'): string;
}
