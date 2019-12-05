<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\DB;

/*include_once('productos.php');
require_once('depositos.php');
require_once('movimientos_mp.php');*/

Route::get('/', function () {
	$ventas=DB::select("SELECT sum(total) as total FROM vista_ventas 
		where month(fecha)=month(now()) ");
	$ventas=$ventas[0]->total;
	$pendientes=DB::select("select count(*) as cant FROM ventas where estado in (0,1)");
	//print_r($pendientes);die();
	$pendientes=$pendientes[0]->cant;
	$en_produccion=DB::select("select count(*) as abiertos from lotes_produccion where estado=1;");
	$en_produccion=$en_produccion[0]->abiertos;
	$valorizado=DB::select("select sum(p.precio_costo*s.cantidad) as subtotal FROM saldos s, productos p WHERE p.id=s.id_producto and p.tipo_producto_id not in (4,7);");
	$valorizado=$valorizado[0]->subtotal;
    return view('inicio',['ventas'=>$ventas, 'valorizado'=>$valorizado,'pendientes'=>$pendientes,'en_produccion'=>$en_produccion]);
});






