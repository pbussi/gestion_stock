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

Route::get('/', function () {
    return view('inicio');
});


Route::get('/productos', function () {
	$productos = DB::select('select productos.*,tipo_producto.nombre as tipo_nombre from productos,tipo_producto where productos.tipo_producto_id=tipo_producto.id');
    return view('productos', ['productos' => $productos]);
});

Route::get('/depositos', function () {
	$depositos = DB::select('select * from depositos where visible=true');
    return view('depositos', ['depositos' => $depositos]);
})->name('depositos');

Route::get('/deposito_nuevo', function () {
    return view('deposito_nuevo');
});

Route::post('/deposito_nuevo', function () {
	//print_r($_POST);
	$depositos = DB::select('insert into depositos values (NULL,?,?,1)',[$_POST['nombre'],$_POST['direccion']]);
    return redirect()->route('depositos');
});