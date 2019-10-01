<?php

Route::get('/lote_produccion_nuevo', function () {
    return view('lote_produccion_nuevo', []);
})->name('lote_produccion_nuevo');


Route::post('/lote_produccion_nuevo', function () {
	$mov=DB::select('insert into lotes_produccion values (NULL,?,NULL,NULL,NULL)',[$_POST['fecha_lote']]);
    return view('lote_produccion_nuevo', []);
})->name('lote_produccion_nuevo');


Route::get('/lotes_produccion_gestion/{id}', function ($id) {
	$lote=DB::select('select * from lotes_produccion where id=?',[$id]);
	$productos=DB::select('select * from productos');
	$lote = $lote[0];
	$ingredientes=DB::select('select * from mp_lote_produccion lp,lotes_mp mp,productos p where lotes_prod_id=? and lp.lotes_mp_id=mp.id and mp.productos_id=p.id',[$id]);
    return view('lotes_produccion_gestion', ['ingredientes'=>$ingredientes,'lote'=>$lote,'productos'=>$productos]);
})->name('lotes_produccion_nuevo');


Route::post('/lotes_produccion_gestion/{id}', function ($id) {
	$lote=DB::select('select * from lotes_produccion where id=?',[$id]);
	$productos=DB::select('select * from productos');
	$lote = $lote[0];
	$ingredientes=DB::select('select * from mp_lote_produccion lp,lotes_mp mp,productos p where lotes_prod_id=? and lp.lotes_mp_id=mp.id and mp.productos_id=p.id',[$id]);
    return view('lotes_produccion_gestion', ['ingredientes'=>$ingredientes,'lote'=>$lote,'productos'=>$productos]);
})->name('lotes_produccion_nuevo');