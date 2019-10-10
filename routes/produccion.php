<?php



Route::get('/lotes_produccion', function () {
	$lotes=DB::select('select * from lotes_produccion order by fecha desc',[]);
	
    return view('lotes_produccion',['lotes' => $lotes]);
})->name('lotes_produccion');;


Route::get('/lote_produccion_nuevo', function () {
    return view('lote_produccion_nuevo', []);
})->name('lote_produccion_nuevo');

Route::get('/lote_produccion_nuevo', function () {
    return view('lote_produccion_nuevo', []);
})->name('lote_produccion_nuevo');

Route::get('/lote_produccion_cambiar_estado/{id}', function ($id) {
	DB::select('update lotes_produccion set estado=not estado where id=?',[$id]);
})->name('lote_produccion_cambiar_estado');


Route::get('/lotes_produccion_gestion/{id}', function ($id) {
	if (isset($_GET['borrar'])){
		DB::select('delete from mp_lote_produccion where movimiento_id=?',[$_GET['borrar']]);
		DB::select('delete from movimientos where id=?',[$_GET['borrar']]);
	}
	$lote=DB::select('select * from lotes_produccion where id=?',[$id]);
	$productos=DB::select('select * from productos');
	$lote = $lote[0];
	$ingredientes=DB::select('select * from mp_lote_produccion lp,lotes_mp mp,productos p where lotes_prod_id=? and lp.lotes_mp_id=mp.id and mp.productos_id=p.id',[$id]);
    return view('lotes_produccion_gestion', ['ingredientes'=>$ingredientes,'lote'=>$lote,'productos'=>$productos]);
})->name('lotes_produccion_gestion');


Route::post('/lotes_produccion_gestion/{id}', function ($id) {
	$mov=DB::select("insert into movimientos values (NULL,NOW(),?,?,'',?,NULL,?)",[-$_POST['cantidad'],$_POST['deposito'],$_POST['lote'],"PROD".str_pad($id,6,"0", STR_PAD_LEFT)]);	
	$id_movimiento = DB::getPdo()->lastInsertId();
	$mov=DB::select('insert into mp_lote_produccion values (NULL,?,?,?,?)',[$id,$_POST['lote'],$id_movimiento,$_POST['cantidad']]);	

    return redirect()->route('lotes_produccion_gestion',$id)->with('success','Item agregado!');
})->name('lotes_produccion_gestion_post');