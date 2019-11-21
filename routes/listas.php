<?php

Route::get('/listas', function () {
	$listas = DB::select('select * from lista_precios');
    return view('listas', ['listas' => $listas]);
})->name('listas');

Route::get('/lista_edit/{id}', function ($id) {
	$lista = DB::select('select * from lista_precios where id=?',[$id]);
	$lista = $lista[0];
    return view('lista_edit',['lista' => $lista]);
});

Route::post('/lista_edit', function () {
	$lista = DB::select('update lista_precios set nombre=? where id=?',[$_POST['nombre'],$_POST['id']]);
    return redirect()->route('listas')->with('success','Lista actualizada!');; 
   
});

Route::get('/lista_borrar/{id}', function ($id) {
	$cuenta = DB::select('select count(*) as cant from clientes where lista_precios_id=?',[$id]);
	if ($cuenta[0]->cant>0)
	{
		return redirect()->route('listas')->with('error',"No se puede eliminar la lista seleccionada. Está siendo utilizada por clientes");	
	}
	
	$cuenta = DB::select('select count(*) as cant from ventas where lista_precios_id=?',[$id]);
	if ($cuenta[0]->cant>0)
	{
		return redirect()->route('listas')->with('error',"No se puede eliminar la lista seleccionada.  La misma tiene ventas asociadas.  Puede inhabilitarla");	
	}
	
	try {	
		$items = DB::select('delete from item_lista_precios where lista_precios_id=?',[$id]);
		$lista = DB::select('delete from lista_precios where id=?',[$id]);
	} 
	catch (Exception $e){
		return redirect()->route('listas')->with('error',"No se ha podido eliminar la lista seleccionada.");
	}
	
	return redirect()->route('listas')->with('success','Lista de Precios eliminada!');
});

Route::get('/lista_nueva', function () {
    return view('lista_nueva');
});

Route::post('/lista_nueva', function () {
	$Lista = DB::select('insert into lista_precios values (NULL,?)',[$_POST['nombre']]);

	$id = DB::getPdo()->lastInsertId();
	DB::select("insert into item_lista_precios select null,id,$id,0 from productos where tipo_producto_id not in (4,7) ");
	
    return redirect()->route('listas')->with('success','Lista de Precios creada!');
});

Route::get('/lista_precios_seleccion', function () {
$listas = DB::select('select * from lista_precios');
    return view('lista_precios_seleccion', ['listas' => $listas]);
});


Route::get('/lista_gestion/{id}', function ($id) {

	$items=DB::select("select i.id,i.productos_id,i.lista_precios_id, i.precio,p.codigo, p.nombre, p.marca, p.unidad_medida,p.tipo_producto_id, t.nombre as tipo from item_lista_precios i, productos p, tipo_producto t where i.lista_precios_id=? and i.productos_id=p.id and p.tipo_producto_id=t.id and p.tipo_producto_id not in (4,7)",[$id]);
	$lista=DB::select("select * from lista_precios where id=?",[$id]);
	$lista=$lista[0];
	$faltantes=DB::select("select * from productos where tipo_producto_id not in (4,7) and id not in (select productos_id from item_lista_precios where lista_precios_id=?)",[$id]);
 	return view('lista_gestion', ['items' => $items,'lista'=>$lista,'faltantes'=>$faltantes ]);
})->name('lista_gestion');;


Route::post('/lista_gestion', function () {
	foreach($_POST['precios'] as $clave=>$valor){
	$valor=str_replace(".", "", $valor);
	$valor=str_replace(",", ".", $valor);
	DB::select("update item_lista_precios set precio=? where id=?",[$valor,$clave]);
	}
 	return redirect()->route('lista_gestion',["id"=>$_POST["lista_id"]])->with('success','Lista de Precios actualizada!');
});


Route::post('/lista_gestion_agregar', function () {
	DB::select("insert into item_lista_precios values (null,?,?,0)",[$_POST['item'],$_POST['lista_id']]);
 	return redirect()->route('lista_gestion',["id"=>$_POST["lista_id"]])->with('success','Item agregado!');
});


Route::get('/lista_pdf/{id}', function ($id) {
	$items=DB::select("select i.id,i.productos_id,i.lista_precios_id, i.precio,p.codigo, p.nombre, p.marca, p.unidad_medida,p.tipo_producto_id, t.nombre as tipo 
		from item_lista_precios i, productos p, tipo_producto t 
		where i.lista_precios_id=? and i.productos_id=p.id and p.tipo_producto_id=t.id and p.tipo_producto_id not in (4,7) order by p.nombre asc;",[$id]);

	$lista=DB::select("select * from lista_precios where id=?",[$id]);
	$lista=$lista[0];

	$matriz=array();
	foreach ($items as $i) {
		$matriz[$i->id]['codigo']=$i->codigo;
		$matriz[$i->id]['nombre']=$i->nombre;
		$matriz[$i->id]['marca']=$i->marca;
		$matriz[$i->id]['unidad_medida']=$i->unidad_medida;
		$matriz[$i->id]['tipo']=$i->tipo;
		$matriz[$i->id]['precio']=$i->precio;		
	}
	
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->Image('images/rincon.jpeg',180,6,15,15);
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,"Lista de Precios ".$lista->nombre);
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Write(5,"Fecha:".date("d/m/Y",time()));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$cols=array();$aligns=array();

	$cols[]=25;$titulos[]="COD";$aligns[]="L";
	$cols[]=60;$titulos[]="Producto";$aligns[]="L";
	$cols[]=20;$titulos[]="Marca";$aligns[]="L";
	$cols[]=20;$titulos[]="U.M.";$aligns[]="C";
	$cols[]=40;$titulos[]="Tipo de Producto";$aligns[]="C";
	$cols[]=20;$titulos[]="$ Precio";$aligns[]="R";

	$pdf->SetWidths($cols);$pdf->SetAligns($aligns);
	$pdf->Row($titulos);

	foreach($matriz as $m){

		$row=array($m['codigo']);
		$row[]=$m['nombre'];
		$row[]=$m['marca'];
		$row[]=$m['unidad_medida'];
		$row[]=$m['tipo'];
		$row[]=$m['precio'];
	
	    $pdf->Row($row);
	}
	$pdf->Output("D","Lista_Precios.pdf");	

})->name('lista_pdf');


Route::get('/lista_actualizacion_seleccion', function () {
	$listas = DB::select('select * from lista_precios');
    return view('lista_actualizacion_seleccion', ['listas' => $listas]);
})->name('lista_actualizacion_seleccion');

Route::post('/lista_actualizacion_seleccion', function () {
	$lista = DB::select("select * from lista_precios where id=?",[$_POST["lista"]]);
	$lista=$lista[0];
    return view('lista_actualizacion_global', ['lista' => $lista]);
})->name('lista_actualizacion_global');


Route::post('/lista_actualizacion_global', function () {
	$items = DB::select('update item_lista_precios set precio=(precio + (precio*?)/100) where lista_precios_id=?',[$_POST['porcentaje'],$_POST['id']]);
    return redirect()->route('lista_precios_informe',['id'=>$_POST['id']])->with('success','Lista de Precios actualizada!');
})->name('lista_actualizacion_global');


Route::get('/lista_precios_informe/{id}', function ($id) {

	$items=DB::select("select i.id,i.productos_id,i.lista_precios_id, i.precio,p.codigo, p.nombre, p.marca, p.unidad_medida,p.tipo_producto_id, t.nombre as tipo from item_lista_precios i, productos p, tipo_producto t where i.lista_precios_id=? and i.productos_id=p.id and p.tipo_producto_id=t.id and p.tipo_producto_id not in (4,7) order by p.nombre asc",[$id]);
	$lista=DB::select("select * from lista_precios where id=?",[$id]);
	$lista=$lista[0];
	return view('lista_precios_informe',['items'=>$items, 'lista'=>$lista]);
})->name('lista_precios_informe');