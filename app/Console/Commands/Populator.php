<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Populator extends Command
{
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
     * Execute the console command.
     */
    public function handle(): void
    {
        //
    }
}
