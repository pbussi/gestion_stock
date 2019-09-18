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
