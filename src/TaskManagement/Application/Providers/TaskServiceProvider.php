<?php

namespace TaskManagement\Application\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use TaskManagement\Task\Controller\TaskController;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->addRoutes($router);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function addRoutes($router)
    {
        $router->group(['prefix' => 'api', 'middleware' => 'api'], function () use($router) {
            $router->get('/tasks',[
                'as'   => 'tasks.index',
                'uses' => TaskController::class . '@index'
            ]);

            $router->post('/tasks/store',[
                'as'   => 'tasks.store',
                'uses' => TaskController::class . '@store'
            ]);

            $router->get('/tasks/{id}',[
                'as'   => 'tasks.show',
                'uses' => TaskController::class . '@show'
            ]);

            $router->put('/tasks/update',[
                'as'   => 'tasks.update',
                'uses' => TaskController::class . '@store'
            ]);

            $router->get('/tasks/{id}/delete',[
                'as'   => 'tasks.delete',
                'uses' => TaskController::class . '@destroy'
            ]);
        });
    }
}
