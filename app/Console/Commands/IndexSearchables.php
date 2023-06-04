<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\Searchable;

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
            fn(string $str) =>
                str_starts_with($str, 'App\\Models\\') &&
                in_array(Searchable::class, class_uses($str))
        );
        $this->table(
            ['Class'],
            [$models]
        );
    }
}
