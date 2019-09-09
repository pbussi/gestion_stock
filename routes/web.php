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
	$depositos = DB::select('insert into depositos values (NULL,?,?,?,1)',[$_POST['nombre'],$_POST['direccion'],$_POST['descripcion']]);
    return redirect()->route('depositos')->with('success','Deposito creado!');
});

Route::get('/deposito_edit/{id}', function ($id) {
	$deposito = DB::select('select * from depositos where id=?',[$id]);
	$deposito = $deposito[0];
    return view('deposito_edit',['deposito' => $deposito]);
});

Route::post('/deposito_edit', function () {
	$depositos = DB::select('update depositos set nombre=?,direccion=?, descripcion=? where id=?',[$_POST['nombre'],$_POST['direccion'], $_POST['descripcion'], $_POST['id']]);
    return redirect()->route('depositos')->with('success','Item actualizado!');; 
   
});

Route::get('/deposito_delete/{id}', function ($id) {
	try {
		$deposito = DB::select('delete from depositos where id=?',[$id]);
	} 
	catch (Exception $e){
		return redirect()->route('depositos')->with('error',"No se puede eliminar el item");
	}
	return redirect()->route('depositos')->with('success','Item borrado!');;
});

Route::get('/producto_nuevo', function () {
	$tipos_producto = DB::select('select * from tipo_producto');
    return view('producto_nuevo',['tipos_producto' => $tipos_producto]);
});

Route::post('/producto_nuevo', function () {
	//print_r($_POST);
	DB::select('insert into productos values (NULL,?,?,?,?,?,?,?,?,?)',[$_POST['codigo'],$_POST['nombre'],$_POST['marca'],$_POST['preciocosto'],$_POST['llevastock'],$_POST['stkmin'],$_POST['stkmax'],$_POST['ptoped'],$_POST['unidadmedida'] ]);
    return redirect()->route('productos');
});
