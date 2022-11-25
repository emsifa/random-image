<?php

namespace Emsifa\RandomImage\Commands;

use Illuminate\Console\Command;

class RandomImageCommand extends Command
{
    public $signature = 'random-image';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
