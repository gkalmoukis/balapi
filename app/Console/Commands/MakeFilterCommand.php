<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeFilterCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a new filter class for the given model';

    protected $type = 'Filter';

    protected function getStub()
    {
        return __DIR__.'/stubs/filter.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        if (is_null($this->option('model'))) {
            $this->error('You must provide a model class');

            return false;
        }

        return $rootNamespace.'\Filters\\'.$this->option('model');
    }

    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_REQUIRED, 'Add Model class name for filter'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        parent::handle();
        $this->createFilterFile();

        return 0;
    }

    protected function createFilterFile()
    {
        $class = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($class);
        $content = file_get_contents($path);
        file_put_contents($path, $content);
    }
}