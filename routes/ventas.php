<?php

Route::get('/ventas/{id_venta}/{id_producto}', function ($id_venta,$id_producto) {
if (isset($_GET['borrar']))	{
	$mov=DB::select("SELECT vista_movimientos.id FROM ".$GLOBALS['vista_movimientos']." vista_movimientos,item_venta where productos_id=? and vista_movimientos.id=item_venta.movimientos_id and ventas_id=?",[$id_producto,$id_venta]);
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
	DB::table('saldos')->truncate();
	$x=DB::select("select productos_id,depositos_id,sum(cantidad) as cantidad from ".$GLOBALS['vista_movimientos']." v group by productos_id,depositos_id");
	$ar=array();
	foreach($x as $a) 
		$ar[]=["id_producto"=>$a->productos_id,"id_deposito"=>$a->depositos_id,"cantidad"=>$a->cantidad];
	DB::table('saldos')->insert($ar);

	$productos=DB::select("select * from productos where tipo_producto_id not in (4,7) and id not in (select producto_id from item_pedidos where venta_id=$id)");

	$venta=DB::select("select v.id, v.fecha, v.lista_precios_id,v.clientes_id ,c.razon_social, l.nombre as lista_precios,v.estado from ventas v,clientes c,lista_precios l where v.clientes_id=c.id and v.lista_precios_id=l.id and v.id=$id");

	$items_pedidos=DB::select("select i.id as id_item,p.id,p.codigo,p.nombre,p.unidad_medida,i.cantidad,i.precio from item_pedidos i,productos p where i.producto_id=p.id and i.venta_id=$id ");
	
	$lotes_disponibles=array();
	$saldosxproducto=array();
	$asignaciones=array();
	foreach ($items_pedidos as $item) {
		$lotes_disponibles[$item->id]=DB::select("SELECT d.id as id_deposito,d.nombre as nombre_deposito,lotes_mp_id as id_lote_mp,productos_lote_produccion_id as id_lote_produccion_id,lote as numero_lote,vencimiento, sum(cantidad) as saldo 
		FROM ".$GLOBALS['vista_movimientos']." m,depositos d 
		WHERE  m.depositos_id=d.id and d.id<>13 and productos_id=? group by d.id,d.nombre,lotes_mp_id,productos_lote_produccion_id,lote, vencimiento having sum(cantidad)>0 order by vencimiento asc",[$item->id]);
		$asignaciones[$item->id]=DB::select("SELECT * from item_venta i,".$GLOBALS['vista_movimientos']." v where i.movimientos_id=v.id and i.ventas_id=? and v.productos_id=?",[$id,$item->id]);
		$saldosxproducto[$item->id]= DB::select("select s.id_producto,s.cantidad,d.nombre,p.unidad_medida from saldos s,depositos d, productos p where s.id_producto=p.id and s.id_deposito=d.id and p.id=?;",[$item->id]);

	}
    return view('venta_gestion', ['item_pedidos'=>$items_pedidos,'productos'=>$productos,'lotes_disponibles'=>$lotes_disponibles,'asignaciones'=>$asignaciones,'venta'=>$venta[0],'saldo_producto'=>$saldosxproducto]);
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
		if($valor>0){
		$clave=explode(",", $clave);
		$formulario="REM".str_pad($id,6,"0", STR_PAD_LEFT);		
		$deposito_id=$clave[0];
		if ($clave[1]=="") $lote_mp=NULL; else $lote_mp=$clave[1];
		if ($clave[2]=="") $lote_pr=NULL; else $lote_pr=$clave[2];
		$mov=DB::select('insert into movimientos values (NULL,NOW(),?,?,?,?,?,?)',[-$valor,$deposito_id,'',$lote_mp,$lote_pr,$formulario]);
		$id_movimiento = DB::getPdo()->lastInsertId();
		$mov=DB::select('insert into item_venta values (NULL,?,?,?)',[$id,$id_movimiento,$_POST['precio']]);
		}
	}
	return redirect()->route('venta_gestion',$id);
})->name('asignar_lotes_venta');




Route::get('/desasignar_lotes_venta/{venta_id}/{producto_id}', function ($venta_id,$producto_id) {
	$mov=DB::select("SELECT vista_movimientos.id FROM ".$GLOBALS['vista_movimientos']."  vista_movimientos,item_venta where productos_id=? and vista_movimientos.id=item_venta.movimientos_id and ventas_id=?",[$producto_id,$venta_id]);
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
	if (!(is_numeric($_POST['nuevo_precio'])))
		return redirect()->route('venta_gestion',$id)->with('error','Precio no valido');
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
			FROM ".$GLOBALS['vista_movimientos']."  m,depositos d 
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
		$mov=DB::select("SELECT vista_movimientos.id FROM ".$GLOBALS['vista_movimientos']." vista_movimientos,item_venta where  vista_movimientos.id=item_venta.movimientos_id and ventas_id=?",[$_GET['borrar']]);
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


Route::get('/pedidos_seleccion_cliente', function () {
	
	$clientes=DB::select("select * from clientes");

return view('pedidos_seleccion_cliente',['clientes'=>$clientes]);	
})->name('pedidos_seleccion_cliente');



Route::post('/pedidos_seleccion_cliente',function () {

	$cliente=DB::select ("select * from clientes where id=?",[$_POST['cliente']]);
	$cliente=$cliente[0];
	$desde=$_POST['fecha_desde'];
	$hasta=$_POST['fecha_hasta'];
	
	$ventascliente=DB::select ("select v.id, v.fecha, v.clientes_id, c.razon_social from ventas v, clientes c where v.clientes_id=? and v.clientes_id=c.id and v.fecha>=? and v.fecha<=? order by v.fecha asc",[$_POST['cliente'],$desde,$hasta]);
	//print_r($ventascliente);
	$datos_ventas=array();
	
	foreach ($ventascliente as $v) {
		$formulario="REM".str_pad($v->id,6,"0", STR_PAD_LEFT);	
		$datos_ventas[$v->id]=DB::select("select m.cantidad, m.comprobante_asociado, m.productos_id, i.precio, p.nombre,i.precio*(-m.cantidad) as subtotal from ".$GLOBALS['vista_movimientos']."  m, productos p, item_venta i where i.ventas_id=? and m.comprobante_asociado like ? and m.productos_id=p.id and i.movimientos_id=m.id;",[$v->id,$formulario]);		
	}
	//print_r($datos_ventas);
	
    return view('pedidos_cliente', ['ventascliente'=>$ventascliente, 'datos_ventas'=>$datos_ventas, 'cliente'=>$cliente,'desde'=>$desde, 'hasta'=>$hasta]);
})->name('pedidos_cliente');


Route::get('/estadistica_productos_seleccion', function () {	
		return view('estadistica_productos_seleccion');	
})->name('estadistica_productos_seleccion');


Route::post('/estadistica_productos_seleccion', function () {	

	$valor = $_POST['opciones'];
		if($valor=="1") {//historico
			$desde="";
			$hasta="";
			$ranking=DB::select("select m.productos_id,p.nombre,p.unidad_medida, -sum(cantidad) as total_producto from ".$GLOBALS['vista_movimientos']." m,productos p where m.comprobante_asociado like 'REM%' and m.productos_id=p.id GROUP by m.productos_id,p.nombre, p.unidad_medida order by total_producto desc;");	
		}
		else {

			$desde=date('Y-m-d', strtotime($_POST['fecha_desde']));
			$hasta=date('Y-m-d', strtotime($_POST['fecha_hasta']));
			$ranking=DB::select("select m.productos_id,p.nombre, p.unidad_medida,-sum(cantidad) as total_producto from ".$GLOBALS['vista_movimientos']." m,productos p where m.comprobante_asociado like 'REM%' and m.productos_id=p.id and m.fecha>=? and m.fecha<=? GROUP by m.productos_id,p.nombre, p.unidad_medida order by total_producto desc;",[$desde,$hasta]);	
		}
			
	
		return view('estadistica_productos',['listado'=>$valor, 'desde'=>$desde, 'hasta'=>$hasta,'ranking'=>$ranking]);	
})->name('estadistica_productos_seleccion');




Route::get('/remitos_pdf/{id}', function ($id) {
	$venta=DB::select('select * from ventas v, clientes c where v.id=? and c.id=v.clientes_id',[$id]);	
	$venta = $venta[0];	
	$formulario="REM".str_pad($id,6,"0", STR_PAD_LEFT);	
	//$items_venta=array();
	$items_venta=DB::select("select p.unidad_medida, v.productos_id, p.codigo,p.nombre, i.precio, -sum(v.cantidad) as subtotal from ".$GLOBALS['vista_movimientos']." v, productos p, item_venta i where i.ventas_id=? and i.movimientos_id=v.id and p.id=v.productos_id group by p.unidad_medida, v.productos_id, p.codigo,p.nombre, i.precio;",[$id]);

		foreach ($items_venta as $i){
				$items_venta_con_lotes_asignados[$i->productos_id]=DB::select ("select v.depositos_id,v.nombre_deposito,v.lote, -v.cantidad as cant from ".$GLOBALS['vista_movimientos']." v, item_venta i where i.ventas_id=? and i.movimientos_id=v.id and v.productos_id=?",[$id,$i->productos_id]);
		}

    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	//$pdf->Image('images/rincon.jpeg',175,6,15,15);
	$pdf->SetFont('Arial','',15);
	$pdf->SetFillColor(0, 0, 0);
	$pdf->SetTextColor(255,255,255);
	$titulo="REMITO Nro. ".$formulario;
    $total_pedido=0;
	$pdf->Cell(190, 10, $titulo, 0, 0, 'C', true);
	$pdf->SetTextColor(0,0,0);
	//$pdf->Write(5,$titulo,'',1,'R');
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	

	$pdf->SetFillColor(255, 255, 255);
	$pdf->Ln();
	$pdf->Cell(135, 5, "CLIENTE: ". strtoupper($venta->razon_social) , 0, 0, 'L', true);
	$pdf->Cell(50, 5, "Fecha: ". date('d-m-Y', strtotime($venta->fecha)), 0, 0, 'R', true); 
	$pdf->Ln();$pdf->Ln();
	$pdf->Cell(180, 5, "Direccion: ".$venta->direccion , 0, 0, 'L', true);
	$pdf->Ln();
	$pdf->Cell(180, 5, "Localidad: ".$venta->localidad , 0, 0, 'L', true);
	$pdf->Ln();
	$pdf->Cell(180, 5, "Provincia: ".$venta->provincia , 0, 0, 'L', true);
	$pdf->Ln();
	$pdf->Ln();$pdf->Ln();$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->SetWidths(array(30,90,10,20,20,20,30));
	$pdf->SetAligns(array('L','L','L','C','R','C'));
	$pdf->Row(array("Codigo ","Producto", "U.M.","Cantidad","Precio"," $ Total"));
	$pdf->SetAligns(array('L','L','C','R','R', 'R'));


//	$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
//$pdf->setCellMargins(1, 1, 1, 1);

	foreach ($items_venta as $i){
		$pdf->Row(array($i->codigo,$i->nombre,$i->unidad_medida,$i->subtotal,$i->precio, "$ ".(($i->subtotal)*($i->precio))));
		$total_pedido=$total_pedido + ($i->precio*$i->subtotal);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(30, 7," ", 0, 0, 'L');
		$pdf->Cell(10, 7," ", 1, 0, 'L');
		$pdf->Cell(30, 7, "Deposito", 1 ,0, 'C');$pdf->Cell(30, 7, "Lote Asignado", 1 ,0, 'Cß');$pdf->Cell(20, 7, "Cantidad", 1 ,1, 'R');
		foreach ($items_venta_con_lotes_asignados[$i->productos_id] as $l){
				
				$pdf->Cell(30, 7," ", 0, 0, 'L');
				$pdf->Cell(10, 7," ", 1, 0, 'L');
				$pdf->Cell(30, 7, $l->nombre_deposito, 1 ,0, 'L');
				$pdf->Cell(30, 7, $l->lote, 1 ,0, 'L');
				$pdf->Cell(20, 7, $l->cant , 1 ,1, 'R');
		}
		$pdf->Ln();
		$pdf->SetFont('Arial','',9);

	}
	
	$pdf->Ln();	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	

	$pdf->Cell(190, 8, "TOTAL DEL PEDIDO: $ ". $total_pedido, 0, 1, 'R', false);
		$pdf->Output("D",$formulario.".pdf");
})->name('remitos_pdf');



Route::get('/ventas_no_cumplidas_seleccion', function () {	
		return view('ventas_no_cumplidas_seleccion');	
})->name('ventas_no_cumplidas_seleccion');


Route::post('/ventas_no_cumplidas_seleccion', function () {	
	$resultado=array();
	$valor = $_POST['opciones'];
	if($valor=="1") {//historico
		$desde="";
		$hasta="";
		$items_pedidos=DB::select("select p.codigo,p.nombre,p.unidad_medida, i.producto_id, i.venta_id, i.cantidad as cant_pedida,v.fecha, c.razon_social from productos p, item_pedidos i,ventas v, clientes c where v.id=i.venta_id and p.id=i.producto_id and v.clientes_id=c.id order by i.producto_id;");
	}
	else {
		$desde=date('Y-m-d', strtotime($_POST['fecha_desde']));
		$hasta=date('Y-m-d', strtotime($_POST['fecha_hasta']));
		$items_pedidos=DB::select("select p.codigo,p.nombre,p.unidad_medida, i.producto_id, i.venta_id, i.cantidad as cant_pedida, v.fecha, c.razon_social from productos p, item_pedidos i, ventas v, clientes c where p.id=i.producto_id and v.id=i.venta_id and v.clientes_id=c.id and v.fecha>=? and v.fecha<=? order by i.producto_id;",[$desde, $hasta]);
	}
	foreach ($items_pedidos as $item){
		$enviados=DB::select("select mv.productos_id, mv.comprobante_asociado,-sum(cantidad) as cant_enviada from ".$GLOBALS['vista_movimientos']." mv, item_venta v where v.ventas_id=? and v.movimientos_id=mv.id and mv.productos_id=? group by mv.productos_id, mv.comprobante_asociado;",[$item->venta_id,$item->producto_id]);
		if(count($enviados)==0) {
			$cantidad_enviada=0;
			$comp="";
		}
		else {
			$cantidad_enviada=$enviados[0]->cant_enviada;
			$comp=$enviados[0]->comprobante_asociado;
		}
		if ($cantidad_enviada<$item->cant_pedida){
			$resultado[$item->nombre][]=array("codigo"=>$item->codigo,"nombre"=>$item->nombre,"cant_pedida"=>$item->cant_pedida,"cant_enviada"=>$cantidad_enviada,"unidad_medida"=>$item->unidad_medida,"fecha_venta"=>$item->fecha,"cliente"=>$item->razon_social, "remito"=>$comp);
		}
	}
	//print_r(resultado);

	return view('ventas_no_cumplidas',[ 'valor'=>$valor, 'desde'=>$desde, 'hasta'=>$hasta,'resultado'=>$resultado]);	
		
})->name('ventas_no_cumplidas');




Route::get('/ventas_seleccion', function () {	
		return view('ventas_seleccion');	
})->name('ventas_seleccion');


Route::post('/ventas_seleccion', function () {	
	$valor = $_POST['opciones'];
	if($valor=="1") {//historico
		$desde="";
		$hasta="";
		$ventas=DB::select ("select * from ".$GLOBALS['vista_ventas']." vista_ventas");	
	}
	else {
		$desde=date('Y-m-d', strtotime($_POST['fecha_desde']));
		$hasta=date('Y-m-d', strtotime($_POST['fecha_hasta']));
		$ventas=DB::select ("select * from ".$GLOBALS['vista_ventas']." vista_ventas where fecha>=? and fecha<=? order by fecha;",[$desde,$hasta]);	
		
	}
	
	return view('ventas_resumen',[ 'valor'=>$valor, 'desde'=>$desde, 'hasta'=>$hasta,'ventas'=>$ventas]);	
		
})->name('ventas_resumen');





Route::get('/ranking_ventas_seleccion', function () {	
		return view('ranking_ventas_seleccion');	
})->name('ranking_ventas_seleccion');


Route::post('/ranking_ventas_seleccion', function () {	
	$valor = $_POST['opciones'];
	if($valor=="1") {//historico
		$desde="";
		$hasta="";
		$ventas=DB::select ("select razon_social, sum(total) as total_cliente from ".$GLOBALS['vista_ventas']." vista_ventas group by razon_social order by total_cliente desc;");	
	}
	else {
		$desde=date('Y-m-d', strtotime($_POST['fecha_desde']));
		$hasta=date('Y-m-d', strtotime($_POST['fecha_hasta']));
		$ventas=DB::select ("select razon_social, sum(total) as total_cliente from ".$GLOBALS['vista_ventas']." vista_ventas where fecha>=? and fecha<=? group by razon_social order by total_cliente desc;",[$desde,$hasta]);	
		
	}
	
	return view('ranking_ventas',[ 'valor'=>$valor, 'desde'=>$desde, 'hasta'=>$hasta,'ventas'=>$ventas]);	
		
})->name('ranking_ventas');



Route::get('/ventasxlote_seleccion', function () {	
		$productos=DB::select("select id,nombre from productos where tipo_producto_id not in(4,7);");
		return view('ventasxlote_seleccion',['productos'=>$productos]);	
})->name('ventasxlote_seleccion');


Route::post('/ventasxlote_seleccion', function () {	
		$producto=DB::select("select * from productos where id=?;",[$_POST['producto']]);
		$producto=$producto[0];

		$ventasxlote=DB::select("select v.id, m.fecha, -m.cantidad as cantidad, m.comprobante_asociado, c.razon_social from ".$GLOBALS['vista_movimientos']." m, clientes c, item_venta i , ventas v where m.productos_id=? and m.lote=? and v.id=i.ventas_id and m.id=i.movimientos_id and v.clientes_id=c.id order by m.fecha asc;",[$_POST['producto'],$_POST['lote']]);

	
	
	return view('ventasxlote',[ 'ventasxlote'=>$ventasxlote, 'lote'=>$_POST['lote'], 'producto'=>$producto]);	
		
})->name('ventasxlote');



//API
Route::get('/lotes_producto/{id}', function ($id) {

	$lotes_producto=DB::select("select p.lotes_produccion_id as id_lote_produccion, m.comprobante_asociado as comprobante FROM productos_lote_produccion p, ".$GLOBALS['vista_movimientos']." m WHERE p.productos_id=? and p.lotes_produccion_id=m.lote and p.productos_id=m.productos_id and m.comprobante_asociado like 'PROD%' order by p.lotes_produccion_id desc;",[$id]);
	
	return \Response::json($lotes_producto, 200);

});