<?php

namespace App\Modules;

use App\Http\Controllers\CoreCommon;

/**
 * ServiceProvider
 *
 * The service provider for the modules. After being registered
 * it will make sure that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 * @author Kamran Ahmed <kamranahmed.se@gmail.com>
 * @package App\Modules
 */
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot()
    {
        // For each of the registered modules, include their routes and Views

        $modules = CoreCommon::GetModulesName();

        foreach ($modules as $module) {

            // Load the routes for each of the modules
            if (file_exists(__DIR__ . '/' . $module . '/Admin/routes.php')) {
                include __DIR__ . '/' . $module . '/Admin/routes.php';
            }
            if(file_exists(__DIR__.'/'.$module.'/Web/routes.php')) {
                include __DIR__.'/'.$module.'/Web/routes.php';
            }


            // Load the views
            if (is_dir(__DIR__ . '/' . $module . '/Admin/Views')) {
                $this->loadViewsFrom(__DIR__ . '/' . $module . '/Admin/Views', $module . '_Admin');
            }

            if(is_dir(__DIR__.'/'.$module.'/Web/Views')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Web/Views',$module.'_Web');
            }

        }
    }

    public function register()
    {
    }

}
