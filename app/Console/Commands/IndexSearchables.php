<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Traits\Searchable;
use Illuminate\Console\Command;

class IndexSearchables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:index-searchables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $classes = get_declared_classes();
        sort($classes);
        $autoload = require base_path('vendor/composer/autoload_classmap.php');
        $autoloadKeys = array_keys($autoload);
        $models = array_filter(
            $autoloadKeys,
            fn (string $str) => str_starts_with($str, 'App\\Models\\') &&
                in_array(Searchable::class, class_uses($str), true)
        );
        $this->table(
            ['Class'],
            [$models]
        );
    }
}
