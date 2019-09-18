<?php


Route::get('/movimiento_mp_ingreso_seleccion', function () {
    return view('movimiento_mp_ingreso_seleccion',['productos'=>[]]);
})->name('movimiento_mp_ingreso_seleccion');


Route::post('/movimiento_mp_ingreso_seleccion', function () {
	$texto_busqueda=$_POST['buscar'];
	$productos = DB::select("select * from productos where concat(nombre,marca,codigo) like '%$texto_busqueda%'");
	if (count($productos)>1) 
		return view('movimiento_mp_ingreso_seleccion',['productos'=>$productos]);
	if (count($productos)==0) 
		return redirect()->route('movimiento_mp_ingreso_seleccion')->with('error','No encontrado!');	
	$producto=$productos[0];
    return redirect()->route('movimiento_mp_ingreso', ['id' => $producto->id]);	
})->name('movimiento_mp_ingreso_seleccion');


Route::get('/movimiento_mp_ingreso/{id}', function ($id) {
	$productos = DB::select('select * from productos where id=?',[$id]);
	$producto=$productos[0];
	$depositos = DB::select('select * from depositos where visible=true');
    return view('movimiento_mp_ingreso',['producto' => $producto,'depositos' => $depositos,]);
})->name('movimiento_mp_ingreso');
