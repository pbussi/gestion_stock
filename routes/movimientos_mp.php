<?php
include_once("Funciones.php");

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
	$comprobante=talonarioSiguiente("ING");
	$mov=DB::select('insert into movimientos values (NULL,?,?,?,?,?,?,?)',[$_POST['fecha_movimiento'],$_POST['movimiento_cantidad'],$_POST['movimiento_deposito'],$_POST['movimientos_observaciones'],$lotemp->id,NULL,$comprobante]);
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
		WHERE m.lotes_mp_id=l.id and m.depositos_id=d.id and d.id<>13 and l.productos_id=? group by d.id,d.nombre,l.id,l.numero having sum(cantidad)>0',[$id]);

	if (count($saldos)==0) 
		return redirect()->route('movimiento_mp_salida_seleccion')->with('error','Producto sin stock!');	

	$destinos = DB::select('select * from depositos where id<>13');
    return view('movimiento_mp_salida',['producto' => $producto,'saldos' => $saldos, 'destinos'=>$destinos]);
})->name('movimiento_mp_salida');



Route::post('/movimiento_mp_salida', function () {
	$seleccion = explode("-",$_POST['stock_deposito']);
	$id_lote=$seleccion[0];
	$id_deposito=$seleccion[1];
	$saldo_actual=$seleccion[2];
	if($_POST['movimiento_cantidad']<=$saldo_actual){
		$comprobante=talonarioSiguiente("TRANSF");
		//grabo el movimiento de salida
		$mov=DB::select('insert into movimientos values (NULL,?,?,?,?,?,?,?)',[$_POST['fecha_movimiento'],-$_POST['movimiento_cantidad'],$id_deposito,$_POST['movimientos_observaciones'],$id_lote,NULL,$comprobante]);

		DB::select('insert into movimientos values (NULL,?,?,?,?,?,?,?)',[$_POST['fecha_movimiento'],$_POST['movimiento_cantidad'],$_POST['destino'],$_POST['movimientos_observaciones'],$id_lote,NULL,$comprobante]);
		return redirect()->route('movimiento_mp_salida_seleccion')->with('success','Movimiento de Salida registrado correctamente!');

	} else {
		//error - no hay tanto en stock
		return redirect()->route('movimiento_mp_salida',['id'=>$_POST['id']])->with('error','No hay tantos productos en stock. Verifique salida y vuelva a intentar');	
	}
	
 
});


Route::get('/movimiento_producto/{id}', function ($id) {
	$productos = DB::select('select * from productos where id=?',[$id]);
	$producto=$productos[0];
	

	$movs = DB::select('SELECT m.*, d.nombre as deposito, l.numero as lote, l.vencimiento as vencimiento FROM movimientos m, lotes_mp l, depositos d where m.lotes_mp_id=l.id and d.id<>13 and l.productos_id=? and m.depositos_id=d.id order by fecha asc;',[$id]);


	$movimientos=array();
	foreach ($movs as $mov) {
		$movimientos[$mov->deposito][]=$mov;
	}

	$saldoxdep=DB::select('select m.depositos_id as dep, sum(cantidad) as saldo from movimientos m, lotes_mp l where l.id=m.lotes_mp_id and l.productos_id=? group by m.depositos_id',[$id]);
	

	$saldodeposito=array();
	foreach($saldoxdep as $s){
		$saldodeposito[$s->dep]['saldo']=$s->saldo;
	}
	

    return view('movimiento_producto',['producto' => $producto,'saldosxdep'=>$saldodeposito,'movimientos' => $movimientos,'saldos'=>array()]);
})->name('movimiento_[producto]');



////DESCARTE/////////////////////////////////////////////////////////////////77


Route::get('/movimiento_descarte_seleccion', function () {
	
    return view('movimiento_descarte_seleccion',['productos'=>[]]);
})->name('md');


Route::post('/movimiento_descarte_seleccion', function () {
	$texto_busqueda=$_POST['buscar'];
	$productos = DB::select("select * from productos where concat(nombre,marca,codigo) like '%$texto_busqueda%'");
	if (count($productos)>1) 
		return view('movimiento_descarte_seleccion',['productos'=>$productos]);
	if (count($productos)==0) 
		return redirect()->route('movimiento_descarte_seleccion')->with('error','No encontrado!');	
	$producto=$productos[0];
    return redirect()->route('movimiento_descarte', ['id' => $producto->id]);	
})->name('movimiento_descarte_seleccion');



Route::get('/movimiento_descarte/{id}', function ($id) {
	$productos = DB::select('select * from productos where id=?',[$id]);
	$producto=$productos[0];

	$saldos = DB::select('SELECT d.id as id_deposito,d.nombre as nombre_deposito,l.id as id_lote,l.numero as numero_lote,sum(cantidad) as saldo 
		FROM movimientos m,lotes_mp l,depositos d 
		WHERE m.lotes_mp_id=l.id and m.depositos_id=d.id and d.id<>13 and l.productos_id=? group by d.id,d.nombre,l.id,l.numero having sum(cantidad)>0',[$id]);

	if (count($saldos)==0) 
		return redirect()->route('movimiento_descarte_seleccion')->with('error','Producto sin stock!');	
	return view('movimiento_descarte',['producto' => $producto,'saldos' => $saldos]);
})->name('movimiento_descarte');



Route::post('/movimiento_descarte', function () {
	$deposito_descarte=13;
	$seleccion = explode("-",$_POST['stock_deposito']);
	$id_lote=$seleccion[0];
	$id_deposito=$seleccion[1];
	$saldo_actual=$seleccion[2];
	if($_POST['movimiento_cantidad']<=$saldo_actual){
		$comprobante=talonarioSiguiente("EGR");
		//grabo el movimiento de salida
		$mov=DB::select('insert into movimientos values (NULL,?,?,?,?,?,?,?)',[$_POST['fecha_movimiento'],-$_POST['movimiento_cantidad'],$id_deposito,$_POST['movimientos_observaciones'],$id_lote,NULL,$comprobante]);

		
		return redirect()->route('movimiento_descarte_seleccion')->with('success','El producto ha sido eliminado correctamente!');

	} else {
		//error - no hay tanto en stock
		return redirect()->route('movimiento_descarte',['id'=>$_POST['id']])->with('error','No hay tantos productos en stock. Verifique salida y vuelva a intentar');	
	}
	
 
});