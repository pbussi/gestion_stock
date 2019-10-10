<?php

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
	return redirect()->route('depositos')->with('success','Item borrado!');
});
