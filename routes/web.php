<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    $filesystem = new Filesystem;

    // instead of having hardcoded paths, we should grab these values from config/livewire.php
    if (!$filesystem->exists(config_path('livewire.php'))){
        error_log('config/livewire.php not found, please publish livewire config to enable automatic routing');
        return;
    }
    
    $component_path = config.get('livewire.class_namespace'); // todo: need to convert namespace to filepath!
    $view_path = config.get('livewire.view_path');
    
    if ($filesystem->exists($dir = $component_path)) {
        foreach ($filesystem->allFiles($dir) as $file) {
            $namespace = 'App\\Components\\' . str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());
            $class = app($namespace);

            if (property_exists($class, 'routeUri') && $class->routeUri) {
                $route = Route::get($class->routeUri, $namespace);

                if (property_exists($class, 'routeName') && $class->routeName) {
                    $route->name($class->routeName);
                }

                if (property_exists($class, 'routeMiddleware') && $class->routeMiddleware) {
                    $route->middleware($class->routeMiddleware);
                }

                if (property_exists($class, 'routeDomain') && $class->routeDomain) {
                    $route->domain($class->routeDomain);
                }

                if (property_exists($class, 'routeWhere') && $class->routeWhere) {
                    $route->where($class->routeWhere);
                }
            }
        }
    }
});
