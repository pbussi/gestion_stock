<?php

Route::get('/ventas/{id_venta}/{id_producto}', function ($id_venta,$id_producto) {
if (isset($_GET['borrar']))	{
	$mov=DB::select("SELECT vista_movimientos.id FROM vista_movimientos,item_venta where productos_id=? and vista_movimientos.id=item_venta.movimientos_id and ventas_id=?",[$id_producto,$id_venta]);
	foreach ($mov as $m){

		DB::select("delete from item_venta where movimientos_id=?",[$m->id]);
		DB::select("delete from movimientos where id=?",[$m->id]);
		
	}
	DB::select("delete from item_pedidos where venta_id=$venta_id and producto_id=$producto_id");
    return view('venta_gestion', [$id_venta]);
}

})->name('ventas');


Route::get('/venta_nueva', function () {
	$listas = DB::select('select * from lista_precios');
	$clientes = DB::select('select * from clientes');
    return view('venta_nueva', ['listas' => $listas,'clientes' => $clientes]);
})->name('venta_nueva');


Route::post('/venta_nueva', function () {
	DB::select("insert into ventas values (NULL,?,?,?,?,0)",[$_POST['fecha'],$_POST['lista'],$_POST['cliente'],$_POST['observaciones']]);	
	$id = DB::getPdo()->lastInsertId();
	return redirect()->route('venta_gestion',$id);
})->name('venta_nueva');

Route::get('/venta_gestion/{id}', function ($id) {
	$productos=DB::select("select * from productos where tipo_producto_id not in (4,7) and id not in (select producto_id from item_pedidos where venta_id=$id)");

	$venta=DB::select("select v.id, v.fecha, v.lista_precios_id,v.clientes_id ,c.razon_social, l.nombre as lista_precios,v.estado from ventas v,clientes c,lista_precios l where v.clientes_id=c.id and v.lista_precios_id=l.id and v.id=$id");

	$items_pedidos=DB::select("select i.id as id_item,p.id,p.codigo,p.nombre,p.unidad_medida,i.cantidad,i.precio from item_pedidos i,productos p where i.producto_id=p.id and i.venta_id=$id ");
	
	$lotes_disponibles=array();
	$asignaciones=array();
	foreach ($items_pedidos as $item) {
		$lotes_disponibles[$item->id]=DB::select("SELECT d.id as id_deposito,d.nombre as nombre_deposito,lotes_mp_id as id_lote_mp,productos_lote_produccion_id as id_lote_produccion_id,lote as numero_lote,vencimiento, sum(cantidad) as saldo 
		FROM vista_movimientos m,depositos d 
		WHERE  m.depositos_id=d.id and d.id<>13 and productos_id=? group by d.id,d.nombre,lotes_mp_id,productos_lote_produccion_id,lote, vencimiento having sum(cantidad)>0 order by vencimiento asc",[$item->id]);
		$asignaciones[$item->id]=DB::select("SELECT * from item_venta i,vista_movimientos v where i.movimientos_id=v.id and i.ventas_id=? and v.productos_id=?",[$id,$item->id]);
	}
    return view('venta_gestion', ['item_pedidos'=>$items_pedidos,'productos'=>$productos,'lotes_disponibles'=>$lotes_disponibles,'asignaciones'=>$asignaciones,'venta'=>$venta[0]]);
})->name('venta_gestion');


Route::post('/venta_gestion_nuevo_item/{id}', function ($id) {
    $formulario="REM".str_pad($id,6,"0", STR_PAD_LEFT);	
	$precio=DB::select("select * from ventas v,lista_precios l,item_lista_precios i where v.id=$id and v.lista_precios_id=l.id and l.id=i.lista_precios_id and i.productos_id=? ",[$_POST['producto']]);	
	$precio_producto=0;
	if (isset($precio[0])){
		$precio_producto=$precio[0]->precio;
	}
	DB::select("insert into item_pedidos values (NULL,?,?,?,?)",[$_POST['producto'],$id,$_POST['cantidad'],$precio_producto]);		
	return redirect()->route('venta_gestion',$id);
})->name('venta_nueva');


Route::post('/asignar_lotes_venta/{id}', function ($id) {
	foreach ($_POST['asignar'] as $clave=>$valor){
		$clave=explode(",", $clave);
		$formulario="REM".str_pad($id,6,"0", STR_PAD_LEFT);		
		$deposito_id=$clave[0];
		if ($clave[1]=="") $lote_mp=NULL; else $lote_mp=$clave[1];
		if ($clave[2]=="") $lote_pr=NULL; else $lote_pr=$clave[2];
		$mov=DB::select('insert into movimientos values (NULL,NOW(),?,?,?,?,?,?)',[-$valor,$deposito_id,'',$lote_mp,$lote_pr,$formulario]);
		$id_movimiento = DB::getPdo()->lastInsertId();
		$mov=DB::select('insert into item_venta values (NULL,?,?,?)',[$id,$id_movimiento,$_POST['precio']]);
	}
	return redirect()->route('venta_gestion',$id);
})->name('asignar_lotes_venta');




Route::get('/desasignar_lotes_venta/{venta_id}/{producto_id}', function ($venta_id,$producto_id) {
	$mov=DB::select("SELECT vista_movimientos.id FROM vista_movimientos,item_venta where productos_id=? and vista_movimientos.id=item_venta.movimientos_id and ventas_id=?",[$producto_id,$venta_id]);
	foreach ($mov as $m){
		$x=DB::delete("delete from item_venta where movimientos_id=?",[$m->id]);
		$x=DB::delete("delete from movimientos where id=?",[$m->id]);
	}
	if (isset($_GET['borrar']))	{
			$x=DB::delete("delete from item_pedidos where venta_id=$venta_id and producto_id=$producto_id");
	}
	return redirect()->route('venta_gestion',$venta_id);
})->name('desasignar_lotes_venta');



Route::get('/venta_cambiar_estado/{id}', function ($id) {
	$estado=$_GET['estado'];
	if ($estado==1 || $estado==2){
		DB::select("update ventas set estado=? where id=?",[$estado,$id]);
	}
	if ($estado==1){
		autoasignarlotes($id);
	}
	return redirect()->route('venta_gestion',$id);
})->name('venta_cambiar_estado');



Route::post('/modificar_precio_item/{id}', function ($id) {
	$nuevo_precio=str_replace(",", ".", $_POST['nuevo_precio']);
	$item=$_POST['item'];
			DB::select("update item_pedidos set precio=? where id=?",[$nuevo_precio,$item]);	
			//echo $item;die;
	return redirect()->route('venta_gestion',$id);
})->name('modificar_precio_item');





function autoasignarlotes($id){
// Asignamos los lotes automaticamente, desde el mas antiguo.
	$formulario="REM".str_pad($id,6,"0", STR_PAD_LEFT);	
	$items_pedidos=DB::select("select * from item_pedidos where venta_id=$id");
	foreach ($items_pedidos as $item) {
	
		$cantidad_asignar=$item->cantidad;
		$lotes_disponibles=DB::select("SELECT d.id as id_deposito,d.nombre as nombre_deposito,lotes_mp_id as id_lote_mp,productos_lote_produccion_id as id_lote_produccion_id,lote as numero_lote,vencimiento, sum(cantidad) as saldo 
			FROM vista_movimientos m,depositos d 
			WHERE  m.depositos_id=d.id and d.id<>13 and productos_id=? group by d.id,d.nombre,lotes_mp_id,productos_lote_produccion_id,lote, vencimiento having sum(cantidad)>0 order by vencimiento asc",[$item->producto_id]);
		foreach ($lotes_disponibles as $lote){	
			if ($cantidad_asignar>0){
				if ($lote->saldo>=$cantidad_asignar){
					$mov=DB::select('insert into movimientos values (NULL,NOW(),?,?,?,?,?,?)',[-$cantidad_asignar,$lote->id_deposito,'',$lote->id_lote_mp,$lote->id_lote_produccion_id,$formulario]);
					$id_movimiento = DB::getPdo()->lastInsertId();
					$mov=DB::select('insert into item_venta values (NULL,?,?,?)',[$id,$id_movimiento,$item->precio]);
						$cantidad_asignar=0;
				}else{
					$mov=DB::select('insert into movimientos values (NULL,NOW(),?,?,?,?,?,?)',[-$lote->saldo,$lote->id_deposito,'',$lote->id_lote_mp,$lote->id_lote_produccion_id,$formulario]);
					$id_movimiento = DB::getPdo()->lastInsertId();
					$mov=DB::select('insert into item_venta values (NULL,?,?,?)',[$id,$id_movimiento,$item->precio]);
						$cantidad_asignar=$cantidad_asignar-$lote->saldo;
				}
			}
		}
	}
}


Route::get('/pedidos_listado', function () {

	if (isset($_GET['borrar']))
	{
	    $formulario="REM".str_pad($_GET['borrar'],6,"0", STR_PAD_LEFT);	
		$mov=DB::select("SELECT vista_movimientos.id FROM vista_movimientos,item_venta where  vista_movimientos.id=item_venta.movimientos_id and ventas_id=?",[$_GET['borrar']]);
		foreach ($mov as $m){
			$x=DB::delete("delete from item_venta where movimientos_id=?",[$m->id]);
			$x=DB::delete("delete from movimientos where id=?",[$m->id]);
		}	

		$x=DB::delete("delete from item_pedidos where venta_id=?",[$_GET['borrar']]);
		DB::select('delete from ventas  where id=?',[$_GET['borrar']]);	

		return redirect()->route('pedidos_listado')->with('success','El pedido ha sido eliminado exitosamente');
	}
$lista_pedidos= DB::select("select v.id, v.fecha, c.razon_social, v.estado from ventas v,clientes c where v.estado in (0,1) and v.clientes_id=c.id order by v.id desc;");

    return view('pedidos_listado', ['pedidos'=>$lista_pedidos]);
})->name('pedidos_listado');


Route::get('/pedidos_enviados', function () {

$lista_pedidos= DB::select("select v.id, v.fecha, c.razon_social, v.estado from ventas v,clientes c where v.estado=2 and v.clientes_id=c.id order by v.id desc;");

$items_pedidos=array();
foreach($lista_pedidos as $venta){

	$item_venta=DB::select ("select i.id,i.ventas_id,i.movimientos_id,i.precio, m.cantidad from item_venta i,movimientos m where i.ventas_id=? and i.movimientos_id=m.id",[$venta->id]);
	$items_pedidos[$venta->id]=0;
	foreach($item_venta as $i){
		$items_pedidos[$venta->id]=$items_pedidos[$venta->id]+(-$i->cantidad*$i->precio);	
	}
}
    return view('pedidos_enviados', ['pedidos'=>$lista_pedidos, 'totales'=>$items_pedidos]);
})->name('pedidos_enviados');


