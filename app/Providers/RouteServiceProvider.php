<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
        $this->mapWebRoutesProductos();
        $this->mapWebRoutesDepositos();
        $this->mapWebRoutesMovimientosMp();
        $this->mapWebRoutesProduccion();
        $this->mapWebRoutesClientes();
        $this->mapWebRoutesListas();
        $this->mapWebRoutesVentas();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutesProductos()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/productos.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutesDepositos()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/depositos.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutesMovimientosMp()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/movimientos_mp.php'));
    }

     /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutesProduccion()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/produccion.php'));
    }
  /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutesClientes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/clientes.php'));
    }
     /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutesListas()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/listas.php'));
    }

 /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutesVentas()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/ventas.php'));
    }


    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
