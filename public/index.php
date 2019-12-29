<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));
 $GLOBALS[vista_movimientos]=" (SELECT m.*,d.nombre as nombre_deposito,d.nombre as deposito,l.productos_id,l.vencimiento as vencimiento,l.numero as lote FROM movimientos m,depositos d,lotes_mp l where d.id=m.depositos_id and m.lotes_mp_id=l.id union 
 SELECT m.*,d.nombre as nombre_deposito,d.nombre as deposito,l.productos_id,DATE_ADD(lp.fecha, INTERVAL 6 MONTH) as vencimiento,l.lotes_produccion_id as lote FROM movimientos m,depositos d,productos_lote_produccion l,lotes_produccion lp where d.id=m.depositos_id and m.productos_lote_produccion_id=l.id and l.lotes_produccion_id=lp.id)";

 $GLOBALS[vista_ventas]=" (SELECT v.id,v.fecha, c.id as clientes_id, c.razon_social,m.comprobante_asociado, sum(i.precio*(-m.cantidad)) as total FROM ventas v,clientes c,item_venta i,".$GLOBALS[vista_movimientos]." m where v.id=i.ventas_id and c.id=v.clientes_id and i.movimientos_id=m.id and v.estado=2 group by v.id,v.fecha, c.id , c.razon_social,m.comprobante_asociado )";


/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
