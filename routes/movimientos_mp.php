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


Route::post('/movimiento_mp_ingreso', function () {

	DB::select('insert ignore into lotes_mp values (NULL,?,?,?)',[$_POST['lote_numero'],$_POST['lote_fechavencimiento'],$_POST['id']]);

	$lotemp = DB::select('select id from lotes_mp where numero=? and productos_id=?',[$_POST['lote_numero'],$_POST['id']]);
	$lotemp = $lotemp[0];
	print_r($lotemp);
	$mov=DB::select('insert into movimientos values (NULL,?,?,?,?,?,?,?)',[$_POST['fecha_movimiento'],$_POST['movimiento_cantidad'],$_POST['movimiento_deposito'],$_POST['movimientos_observaciones'],$lotemp->id,NULL,$_POST['movimiento_comprobante_asociado']]);
	  return redirect()->route('movimiento_mp_ingreso_seleccion')->with('success','Lote ingresado correctamente!');
});


///////////////////////////// EGRESOS //////////////////////////////

Route::get('/movimiento_mp_salida_seleccion', function () {
    return view('movimiento_mp_salida_seleccion',['productos'=>[]]);
})->name('movimiento_mp_salida_seleccion');


Route::post('/movimiento_mp_salida_seleccion', function () {
	$texto_busqueda=$_POST['buscar'];
	$productos = DB::select("select * from productos where concat(nombre,marca,codigo) like '%$texto_busqueda%'");
	if (count($productos)>1) 
		return view('movimiento_mp_salida_seleccion',['productos'=>$productos]);
	if (count($productos)==0) 
		return redirect()->route('movimiento_mp_salida_seleccion')->with('error','No encontrado!');	
	$producto=$productos[0];
    return redirect()->route('movimiento_mp_salida', ['id' => $producto->id]);	
})->name('movimiento_mp_salida_seleccion');



Route::get('/movimiento_mp_salida/{id}', function ($id) {
	$productos = DB::select('select * from productos where id=?',[$id]);
	$producto=$productos[0];

	$saldos = DB::select('SELECT d.id as id_deposito,d.nombre as nombre_deposito,l.id as id_lote,l.numero as numero_lote,sum(cantidad) as saldo 
		FROM movimientos m,lotes_mp l,depositos d 
		WHERE m.lotes_mp_id=l.id and m.depositos_id=d.id and l.productos_id=? group by d.id,d.nombre,l.id,l.numero having sum(cantidad)>0',[$id]);

	if (count($saldos)==0) 
		return redirect()->route('movimiento_mp_salida_seleccion')->with('error','Producto sin stock!');	

	$depositos = DB::select('select * from depositos where visible=true');
    return view('movimiento_mp_salida',['producto' => $producto,'saldos' => $saldos,]);
})->name('movimiento_mp_salida');



Route::post('/movimiento_mp_salida', function () {

	

	$seleccion = explode("-",$_POST['stock_deposito']);
	$id_lote=$seleccion[0];
	$id_deposito=$seleccion[1];
	$saldo_actual=$seleccion[2];
	if($_POST['movimiento_cantidad']<=$saldo_actual){

		//grabo el movimiento de salida
		$mov=DB::select('insert into movimientos values (NULL,?,?,?,?,?,?,?)',[$_POST['fecha_movimiento'],-$_POST['movimiento_cantidad'],$id_deposito,$_POST['movimientos_observaciones'],$id_lote,NULL,$_POST['movimiento_comprobante_asociado']]);
		return redirect()->route('movimiento_mp_salida_seleccion')->with('success','Movimiento de Salida registrado correctamente!');

	} else {
		//error - no hay tanto en stock
		return redirect()->route('movimiento_mp_salida',['id'=>$_POST['id']])->with('error','No hay tantos productos en stock. Verifique salida y vuelva a intentar');	
	}
	
 
});


Route::get('/movimiento_producto/{id}', function ($id) {
	$productos = DB::select('select * from productos where id=?',[$id]);
	$producto=$productos[0];

	$lotes=DB::select('select * from lotes_mp WHERE productos_id=?',[$id]);
	print_r($lotes);

	$saldos = DB::select('SELECT d.id as id_deposito,d.nombre as nombre_deposito,l.id as id_lote,l.numero as numero_lote,sum(cantidad) as saldo 
		FROM movimientos m,lotes_mp l,depositos d 
		WHERE m.lotes_mp_id=l.id and m.depositos_id=d.id and l.productos_id=? group by d.id,d.nombre,l.id,l.numero having sum(cantidad)>0',[$id]);

	
	$depositos = DB::select('select * from depositos where visible=true');
    return view('movimiento_producto',['producto' => $producto,'saldos' => $saldos,]);
})->name('movimiento_[producto]');
