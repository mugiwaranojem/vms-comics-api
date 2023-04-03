<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\PopulatorInterface;

class Populator extends Command
{
    private $populator;

    public function __construct(
        PopulatorInterface $populator
    ) {
        $this->populator = $populator;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate authors and comics table';

    /**
     * Execute populator.
     */
    public function handle(): void
    {
        $this->populator->populate();
        $this->info('The command was successful!');
    }
}
