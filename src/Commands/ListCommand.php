<?php

namespace Redbastie\Skele\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Livewire\Commands\ComponentParser;

class ListCommand extends Command
{
    use ManagesFiles;

    protected $signature = 'skele:list {class} {--model=}';

    public function handle()
    {
        if (!$this->option('model')) {
            $this->warn('A <info>--model</info> must be specified.');

            return;
        }

        $componentParser = new ComponentParser('App\\Components', resource_path('views'), $this->argument('class'));
        $modelParser = new ComponentParser('App\\Models', resource_path('views'), $this->option('model'));

        $this->createFiles('list', [
            'app'. DIRECTORY_SEPARATOR.'Components'. DIRECTORY_SEPARATOR.'DummyComponent.php.stub' => $componentParser->relativeClassPath(),
            'resources'. DIRECTORY_SEPARATOR.'views'. DIRECTORY_SEPARATOR.'DummyView.blade.php.stub' => $componentParser->relativeViewPath(),
            'DummyComponentNamespace' => $componentParser->classNamespace(),
            'DummyComponent' => $componentParser->className(),
            'DummyModelNamespace' => $modelParser->classNamespace(),
            'DummyModelVariables' => Str::camel(Str::plural($modelTitle = preg_replace('/(.)(?=[A-Z])/u', '$1 ', $modelParser->className()))),
            'DummyModelVariable' => Str::camel($modelTitle),
            'DummyModel' => $modelParser->className(),
            'DummyRouteUri' => $dummyRouteUri = str_replace('.', '/', $componentParser->viewName()),
            'DummyViewName' => $componentParser->viewName(),
            'DummyViewTitle' => preg_replace('/(.)(?=[A-Z])/u', '$1 ', $componentParser->className()),
            'DummyWisdom' => $componentParser->wisdomOfTheTao(),
        ]);

        $this->warn('<info>' . $this->argument('class') . '</info> list component & view generated! ' .
            '<href=' . url($dummyRouteUri) . '>' . url($dummyRouteUri) . '</>');
    }
}
