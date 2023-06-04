<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTraitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-trait-command {traitName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a trait';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $traitName = $this->argument('traitName');
        $path = app_path('Traits/' . $traitName);
        $namespacedClass = 'App\\Traits\\' . str_replace('/', '\\', $traitName);

        $namespacedClassArr = explode('\\', $namespacedClass);

        $trait = array_pop($namespacedClassArr);

        $namespace = implode('\\', $namespacedClassArr);

        $traitContent = file_get_contents(base_path('/stubs/trait.stub'));
        $traitContent = str_replace('{{ namespace }}', $namespace, $traitContent);
        $traitContent = str_replace('{{ trait }}', $trait, $traitContent);
        file_put_contents("{$path}.php", $traitContent);
    }
}
