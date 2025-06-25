<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SayHello extends Command
{
    // Signature de la commande
    protected $signature = 'say:hello {name}';

    // Description de la commande
    protected $description = 'Says Hello to the given name';

    public function handle()
    {
        $name = $this->argument('name');
        $this->info("Hello, {$name}");
    }
}
