<?php

Route::get('/productos', function () {
	$productos = DB::select('select productos.*,tipo_producto.nombre as tipo_nombre from productos,tipo_producto where productos.tipo_producto_id=tipo_producto.id');
    return view('productos', ['productos' => $productos]);
})->name('productos');

Route::get('/producto_nuevo', function () {
	$tipos_producto = DB::select('select * from tipo_producto');
    return view('producto_nuevo',['tipos_producto' => $tipos_producto]);
})->name('producto_nuevo');

Route::post('/producto_nuevo', function () {
	//print_r($_POST);
	$imagen='';
	if (isset($_POST['lleva_stock'])) $lleva_stock=1; else $lleva_stock=0;
	try {
	DB::select('insert into productos values (NULL,?,?,?,?,?,?,?,?,?,?,?)',[$_POST['codigo'],$_POST['nombre'],$_POST['marca'],$_POST['precio_costo'],$lleva_stock,$_POST['stock_minimo'],$_POST['stock_maximo'],$_POST['punto_pedido'],$_POST['unidad_medida'],$imagen,$_POST['tipo_producto_id'] ]);
	}
	catch (Exception $e){
		return redirect()->route('producto_nuevo')->with('error',"No se puede crear el item:".$e->getMessage());
	}
    return redirect()->route('productos')->with('success','El producto ha sido creado!');
});

Route::get('/producto_edit/{id}', function ($id) {

	$tipos_producto= DB::select('select * from tipo_producto');
	$producto = DB::select('select *from productos where id=?',[$id]);
	$producto = $producto[0];
	
    return view('producto_edit',['producto' => $producto, 'tipos_producto'=>$tipos_producto,]);
});

Route::post('/producto_edit', function () {
	if (isset($_POST['lleva_stock'])) $lleva_stock=1; else $lleva_stock=0;
	if ($_FILES['foto']['tmp_name']!=''){
		$foto=file_get_contents($_FILES['foto']['tmp_name']);
		$productos = DB::select('update productos set imagen=? where id=?',[$foto,$_POST['id']]);
	}
	$productos = DB::select('update productos set nombre=?,marca=?, unidad_medida=?,lleva_stock=?,tipo_producto_id=?,stock_minimo=?,stock_maximo=?,punto_pedido=?,precio_costo=? where id=?',[$_POST['nombre'],$_POST['marca'], $_POST['unidad_medida'], $lleva_stock,$_POST['tipo_producto_id'],$_POST['stock_minimo'],$_POST['stock_maximo'],$_POST['punto_pedido'],$_POST['precio_costo'],$_POST['id']]);
    return redirect()->route('productos')->with('success','Item actualizado!');; 
   
});





///////////////// APIS


Route::get('/producto_depositos_saldo/{id}', function ($id) {

	$depositos_saldo= DB::select('select d.id as id_deposito,d.nombre,sum(cantidad) from lotes_mp mp, movimientos m,depositos d where mp.productos_id=? and mp.id=m.lotes_mp_id and m.depositos_id=d.id group by d.id,d.nombre',[$id]);
	return \Response::json($depositos_saldo, 200);

});

Route::get('/producto_lotes_saldo/{id_producto}/{id_deposito}', function ($id_producto,$id_deposito) {

	$depositos_saldo= DB::select('select mp.id as id_lote,mp.numero,sum(cantidad) as cantidad from lotes_mp mp, movimientos m,depositos d where d.id=? and mp.productos_id=? and mp.id=m.lotes_mp_id and m.depositos_id=d.id group by mp.id,mp.numero having sum(cantidad)>0',[$id_deposito,$id_producto]);
	return \Response::json($depositos_saldo, 200);

});




///////////////////////SALDOS //////////////////

Route::get('/stock_seleccion_deposito', function () {
	$depositos = DB::select("select * from depositos where visible=true");
    return view('stock_seleccion_deposito',['depositos'=>$depositos]);
})->name('stock_seleccion_deposito');


Route::post('/stock_seleccion_deposito', function () {
	$deposito=DB::select("select * from depositos where id=?",[$_POST['dep']]);
	$deposito=$deposito[0];
	$saldos= DB::select("select * from saldos,productos WHERE id_deposito=? and id_producto=productos.id",[$_POST['dep']]);
		return view('stock_deposito',['deposito'=>$deposito,'saldos'=>$saldos]);	
})->name('stock_deposito');



Route::get('/stock_deposito', function ($id) {
    return view('stock_deposito');
})->name('stock_deposito');