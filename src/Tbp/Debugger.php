<?php
namespace Nolanpro\Tbp;

use Psy\Shell;
use Psy\Configuration;
use Laravel\Tinker\ClassAliasAutoloader;

class Debugger {
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function call($vars, $binding) {
        $config = new Configuration([
            'updateCheck' => 'never'
        ]);
        $config->getPresenter()->addCasters(
            self::getCasters()
        );

        $shell = new Shell($config);
        $shell->setScopeVariables($vars);
        if ($binding !== null) {
            $shell->setBoundObject($binding);
        }

        $path = $this->app->basePath().DIRECTORY_SEPARATOR.'vendor/composer/autoload_classmap.php';

        $loader = ClassAliasAutoloader::register($shell, $path);
        try {
            $shell->run();
        } finally {
            $loader->unregister();
        }
    }

    protected function getCasters()
    {
        // straight up copy/paste
        $casters = [
            'Illuminate\Support\Collection' => 'Laravel\Tinker\TinkerCaster::castCollection',
        ];
        if (class_exists('Illuminate\Database\Eloquent\Model')) {
            $casters['Illuminate\Database\Eloquent\Model'] = 'Laravel\Tinker\TinkerCaster::castModel';
        }
        if (class_exists('Illuminate\Foundation\Application')) {
            $casters['Illuminate\Foundation\Application'] = 'Laravel\Tinker\TinkerCaster::castApplication';
        }
        return $casters;
    }
}