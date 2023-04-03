<?php
namespace App\Contracts;

/**
 * Describes Populator Service.
 */
interface PopulatorInterface
{
    /**
     * Execute populator.
     *
     * @return void
     */
    public function populate(): void;
}
