<?php

Route::get('/productos', function () {
	if (isset($_GET['borrar']))
	{
		try{
		DB::select('delete from productos where id=?',[$_GET['borrar']]);
		}
		catch (Exception $e){
			return redirect()->route('productos')->with('error',"No se puede eliminar el producto seleccionado.  Existen movimientos asociados");
		}
	return redirect()->route('productos')->with('success','El producto ha sido eliminado');
}
	$productos = DB::select('select productos.*,tipo_producto.nombre as tipo_nombre from productos,tipo_producto where productos.tipo_producto_id=tipo_producto.id and tipo_producto_id not in (4,7)');
	$titulos=array("Catalogo de productos","Listado de sabores y productos de fabricación propia","Productos para la Venta");
    return view('productos', ['productos' => $productos,'titulos'=>$titulos]);
})->name('productos');


Route::get('/insumos', function () {
	$productos = DB::select('select productos.*,tipo_producto.nombre as tipo_nombre from productos,tipo_producto where productos.tipo_producto_id=tipo_producto.id and tipo_producto_id in (4,7)');
	$titulos=array("Insumos y Materias Primas","Listado de componentes para la fabricación","Insumos y Materias Primas disponibles para fabricación");
    return view('productos', ['productos' => $productos,'titulos'=>$titulos]);
})->name('insumos');


Route::get('/productos_saldos_pdf', function () {
	if ($_GET['tipo']=="insumos") $conjunto="tipo_producto_id in (4,7)";
	else $conjunto="tipo_producto_id not in (4,7)";
	$productos = DB::select("select p.id as pid,p.nombre as producto,d.id as did,d.nombre as deposito,sum(cantidad) as saldo from productos p,lotes_mp l,movimientos m,depositos d where $conjunto and d.id=m.depositos_id and m.lotes_mp_id=l.id and l.productos_id=p.id and p.lleva_stock=1 and d.id<>13 group by p.id,p.nombre,d.id,d.nombre ");
	$depositos = DB::select("select * from depositos where id<>13");
	$matriz=array();
	foreach ($productos as $p) {
		$matriz[$p->pid]['nombre']=$p->producto;
		$matriz[$p->pid][$p->did]=$p->saldo;
		if (isset($matriz[$p->pid]['total'])) $matriz[$p->pid]['total']+=$p->saldo; 
		else 
				$matriz[$p->pid]['total']=$p->saldo;
		
	}
	
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	if ($_GET['tipo']=="insumos") 
		$pdf->Write(5,"Listado de insumos y saldos.  Fecha:".date("d/m/Y",time()));
	else 
		$pdf->Write(5,"Listado de productos y saldos.  Fecha:".date("d/m/Y",time()));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$cols=array(70);$titulos=array("");$aligns=array("L");
	foreach ($depositos as $d){
		$cols[]=30;$titulos[]=$d->nombre;$aligns[]="R";
	}
	$cols[]=30;$titulos[]="Total";$aligns[]="R";	

	$pdf->SetWidths($cols);$pdf->SetAligns($aligns);
	$pdf->Row($titulos);

	foreach($matriz as $m){
		$row=array($m['nombre']);
		foreach ($depositos as $d){
			if (isset($m[$d->id])) $row[]=$m[$d->id]; else $row[]="0.00";
		}
		$row[]=$m['total'];

	    $pdf->Row($row);
	}
	$pdf->Output("D","reporte_saldos.pdf");
})->name('productos_saldos_pdf');


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
    if(in_array($_POST['tipo_producto_id'],array(1,2,3,6,8) )) 
	    	return redirect()->route('productos')->with('success','Item actualizado!'); 
	else
			return redirect()->route('insumos')->with('success','Item actualizado!');   
});





///////////////// APIS


Route::get('/producto_depositos_saldo/{id}', function ($id) {

	/*$depositos_saldo= DB::select('select d.id as id_deposito,d.nombre,sum(cantidad) from lotes_mp mp, movimientos m,depositos d where mp.productos_id=? and mp.id=m.lotes_mp_id and m.depositos_id=d.id group by d.id,d.nombre  having sum(cantidad)>0',[$id]);*/
	$depositos_saldo= DB::select('select depositos_id as id_deposito,deposito as nombre,sum(cantidad) from vista_movimientos where productos_id=? group by depositos_id,deposito  having sum(cantidad)>0',[$id]);
	return \Response::json($depositos_saldo, 200);

});



Route::get('/producto_lotes_saldo/{id_producto}/{id_deposito}', function ($id_producto,$id_deposito) {

	$depositos_saldo= DB::select('select mp.id as id_lote,mp.numero,sum(cantidad) as cantidad from lotes_mp mp, movimientos m,depositos d where d.id=? and mp.productos_id=? and mp.id=m.lotes_mp_id and m.depositos_id=d.id group by mp.id,mp.numero having sum(cantidad)>0',[$id_deposito,$id_producto]);
	return \Response::json($depositos_saldo, 200);

});



Route::get('/producto_lotes_venta_saldo/{id_producto}/{id_deposito}', function ($id_producto,$id_deposito) {

	$depositos_saldo= DB::select('select lotes_mp_id,productos_lote_produccion_id,lote,sum(cantidad) as cantidad from vista_movimientos where depositos_id=? and productos_id=?  group by lotes_mp_id,productos_lote_produccion_id,lote having sum(cantidad)>0',[$id_deposito,$id_producto]);
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
	$saldos= DB::select("select *, t.nombre as tipo, p.id as producto,p.nombre as nombre_prod from saldos s,productos p, tipo_producto t WHERE s.id_deposito=? and s.id_producto=p.id and t.id=p.tipo_producto_id and s.cantidad>0 order by p.nombre",[$_POST['dep']]);
		return view('stock_deposito',['deposito'=>$deposito,'saldos'=>$saldos]);	
})->name('stock_deposito');





Route::get('/stock_seleccion_deposito_pdf/{id}', function ($id) {
	$prodsxdep = DB::select("select s.id_producto,s.id_deposito,s.cantidad, p.nombre, p.marca, p.unidad_medida, d.nombre as deposito, t.nombre as tipo from saldos s, productos p, depositos d, tipo_producto t WHERE s.id_deposito=? and s.id_deposito=d.id and s.id_producto=p.id and p.tipo_producto_id=t.id and s.cantidad>0; ",[$id]);
	$deposito=DB::select("select * from depositos where id=?",[$id]);
	$deposito=$deposito[0];

	$matriz=array();
	foreach ($prodsxdep as $p) {
		$matriz[$p->id_producto]['nombre']=$p->nombre;
		$matriz[$p->id_producto]['marca']=$p->marca;
		$matriz[$p->id_producto]['tipo']=$p->tipo;
		$matriz[$p->id_producto]['unidad_medida']=$p->unidad_medida;
		$matriz[$p->id_producto]['saldo']=$p->cantidad;		
	}
	
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->Image('images/rincon.jpeg',180,6,15,15);
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,"Stock de Productos en ".$deposito->nombre);
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Write(5,"Fecha:".date("d/m/Y",time()));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$cols=array();$aligns=array();
	$cols[]=70;$titulos[]="Producto";$aligns[]="L";
	$cols[]=30;$titulos[]="Marca";$aligns[]="L";
	$cols[]=30;$titulos[]="Tipo de Producto";$aligns[]="C";
	$cols[]=20;$titulos[]="U.M.";$aligns[]="C";
	$cols[]=30;$titulos[]="Saldos";$aligns[]="R";

	$pdf->SetWidths($cols);$pdf->SetAligns($aligns);
	$pdf->Row($titulos);

	foreach($matriz as $m){

		$row=array($m['nombre']);
		$row[]=$m['marca'];
		$row[]=$m['tipo'];
		$row[]=$m['unidad_medida'];
		$row[]=$m['saldo'];
	
	    $pdf->Row($row);
	}
	$pdf->Output("D","saldo_deposito.pdf");	

})->name('stock_seleccion_deposito_pdf');







Route::get('/saldos_a_fecha', function () {
	
	$stock = DB::select("select p.nombre, p.marca, p.unidad_medida, s.id_producto, sum(cantidad) as cantidad  from saldos s, productos p where s.id_producto=p.id group by p.nombre, p.marca, p.unidad_medida, s.id_producto order by p.nombre asc;",[]);

    return view('saldos_a_fecha',['stock'=>$stock]);
})->name('saldos_a_fecha');


Route::get('/saldos_a_fecha_pdf/', function () {
	$stock = DB::select("select p.nombre, p.marca, p.unidad_medida, s.id_producto, sum(cantidad) as cantidad  from saldos s, productos p where s.id_producto=p.id group by p.nombre, p.marca, p.unidad_medida, s.id_producto;",[]);
	

	$matriz=array();
	foreach ($stock as $p) {
		$matriz[$p->id_producto]['nombre']=$p->nombre;
		$matriz[$p->id_producto]['marca']=$p->marca;
		$matriz[$p->id_producto]['unidad_medida']=$p->unidad_medida;
		$matriz[$p->id_producto]['saldo']=$p->cantidad;		
	}
	
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->Image('images/rincon.jpeg',180,6,15,15);
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,"Stock Actual de Productos");
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Write(5,"Fecha:".date("d/m/Y",time()));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$cols=array();$aligns=array();
	$cols[]=70;$titulos[]="Producto";$aligns[]="L";
	$cols[]=30;$titulos[]="Marca";$aligns[]="L";
	$cols[]=30;$titulos[]="U.M.";$aligns[]="C";
	$cols[]=30;$titulos[]="Saldos";$aligns[]="R";

	$pdf->SetWidths($cols);$pdf->SetAligns($aligns);
	$pdf->Row($titulos);

	foreach($matriz as $m){

		$row=array($m['nombre']);
		$row[]=$m['marca'];
		$row[]=$m['unidad_medida'];
		$row[]=$m['saldo'];
	
	    $pdf->Row($row);
	}
	$pdf->Output("D","saldo_a_fecha.pdf");	

})->name('saldos_a_fecha_pdf');




Route::get('/stock_por_agrupacion_seleccion', function () {

	$agrupacion = array("Productos para la Venta","Materias Primas e Insumos");
    return view('stock_por_agrupacion_seleccion',['agrupacion'=>$agrupacion]);
})->name('stock_por_agrupacion_seleccion');



Route::post('/stock_por_agrupacion_seleccion', function () {
	$titulo=$_POST['grupo'];
	if ($_POST['grupo']=="Productos para la Venta") {
		$g=1;
		$saldos=DB::select("select p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre as tipo_producto, sum(cantidad) as cantidad  from saldos s, productos p, tipo_producto as t where p.tipo_producto_id not in (4,7) and s.id_producto=p.id and t.id=p.tipo_producto_id group by p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre",[]);}
	else{
		$g=2;
		$saldos=DB::select("select p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre as tipo_producto, sum(cantidad) as cantidad  from saldos s, productos p, tipo_producto as t where p.tipo_producto_id  in (4,7) and s.id_producto=p.id and t.id=p.tipo_producto_id group by p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre;",[]);
	}
		return view('stock_agrupacion',['saldos'=>$saldos, 'titulo'=>$titulo,'grupo'=>$g]);	
})->name('stock_agrupacion');



Route::get('/stock_por_agrupacion_pdf/{grupo}', function ($grupo) {
	if ($grupo==1) {
		$saldos=DB::select("select p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre as tipo_producto, sum(cantidad) as cantidad  from saldos s, productos p, tipo_producto as t where p.tipo_producto_id not in (4,7) and s.id_producto=p.id and t.id=p.tipo_producto_id group by p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre",[]); $titulo="PRODUCTOS PARA LA VENTA";
	}
	else{

		$saldos=DB::select("select p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre as tipo_producto, sum(cantidad) as cantidad  from saldos s, productos p, tipo_producto as t where p.tipo_producto_id  in (4,7) and s.id_producto=p.id and t.id=p.tipo_producto_id group by p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre;",[]); $titulo="INSUMOS Y MATERIAS PRIMAS";
	}


	$matriz=array();
	foreach ($saldos as $s) {
		$matriz[$s->id_producto]['nombre']=$s->nombre;
		$matriz[$s->id_producto]['marca']=$s->marca;
		$matriz[$s->id_producto]['tipo']=$s->tipo_producto;
		$matriz[$s->id_producto]['unidad_medida']=$s->unidad_medida;
		$matriz[$s->id_producto]['saldo']=$s->cantidad;		
	}
	
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->Image('images/rincon.jpeg',175,9,15,15);
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,"STOCK ACTUAL  ");
	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,$titulo);
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Write(5,"Fecha:".date("d/m/Y",time()));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$cols=array();$aligns=array();
	$cols[]=70;$titulos[]="Producto";$aligns[]="L";
	$cols[]=30;$titulos[]="Marca";$aligns[]="L";
	$cols[]=30;$titulos[]="Tipo de Producto";$aligns[]="C";
	$cols[]=20;$titulos[]="U.M.";$aligns[]="C";
	$cols[]=30;$titulos[]="Saldos";$aligns[]="R";

	$pdf->SetWidths($cols);$pdf->SetAligns($aligns);
	$pdf->Row($titulos);

	foreach($matriz as $m){

		$row=array($m['nombre']);
		$row[]=$m['marca'];
		$row[]=$m['tipo'];
		$row[]=$m['unidad_medida'];
		$row[]=$m['saldo'];
	
	    $pdf->Row($row);
	}
	$pdf->Output("D","stock_por_agrupacion.pdf");	

})->name('stock_por_agrupacion_pdf');


Route::get('/stock_valorizado', function () {
	
	$stock = DB::select("select p.nombre, p.marca, p.unidad_medida, p.precio_costo, s.id_producto, p.precio_costo*sum(cantidad) as total,sum(cantidad) as cantidad from saldos s, productos p where s.id_producto=p.id group by p.nombre, p.marca, p.unidad_medida, s.id_producto order by p.nombre asc;",[]);


    return view('stock_valorizado',['stock'=>$stock]);
})->name('stock_valorizado');



Route::get('/stock_valorizado_pdf/', function () {
	$stock = DB::select("select p.nombre, p.marca, p.unidad_medida, p.precio_costo, s.id_producto, p.precio_costo*sum(cantidad) as total,sum(cantidad) as cantidad from saldos s, productos p where s.id_producto=p.id group by p.nombre, p.marca, p.unidad_medida, s.id_producto order by p.nombre asc;",[]);

	$matriz=array();
	$acum=0;
	foreach ($stock as $p) {
		$matriz[$p->id_producto]['nombre']=$p->nombre;
		$matriz[$p->id_producto]['marca']=$p->marca;
		$matriz[$p->id_producto]['unidad_medida']=$p->unidad_medida;

		$matriz[$p->id_producto]['precio']=number_format ( $p->precio_costo, 2, "," , "." );
		$matriz[$p->id_producto]['cantidad']=number_format ( $p->cantidad, 2, "," , "." );
		$matriz[$p->id_producto]['saldo']=number_format ( $p->total, 2, "," , "." );
		$acum=$acum+$p->total;		

	}
	
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->Image('images/rincon.jpeg',180,6,15,15);
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,"Stock Valorizado de Productos");
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Write(5,"Fecha:".date("d/m/Y",time()));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$cols=array();$aligns=array();
	$cols[]=65;$titulos[]="Producto";$aligns[]="L";
	$cols[]=30;$titulos[]="Marca";$aligns[]="L";
	$cols[]=20;$titulos[]="U.M.";$aligns[]="C";
	$cols[]=20;$titulos[]="Precio Costo";$aligns[]="R";
	$cols[]=20;$titulos[]="Cantidad";$aligns[]="R";
	$cols[]=30;$titulos[]="Saldo";$aligns[]="R";


	$pdf->SetWidths($cols);$pdf->SetAligns($aligns);
	$pdf->Row($titulos);

	foreach($matriz as $m){

		$row=array($m['nombre']);
		$row[]=$m['marca'];
		$row[]=$m['unidad_medida'];
	    $row[]=$m['precio'];
		$row[]=$m['cantidad'];
	    $row[]=$m['saldo'];
	    $pdf->Row($row);
	}
	$pdf->SetFont('Arial','B',11);
	$pdf->SetWidths(array(155,30));$pdf->SetAligns(array("L","R"));
	$pdf->Row(array("TOTAL",number_format($acum,2,",",".")));
	$pdf->Output("D","stock_valorizado.pdf");	

})->name('stock_valorizado_pdf');




Route::get('/stock_punto_pedido', function () {
	
	$stock = DB::select("select p.nombre, p.marca, p.unidad_medida,p.stock_minimo,p.punto_pedido,p.stock_maximo,s.id_producto, p.tipo_producto_id,sum(cantidad) as cantidad from saldos s, productos p where s.id_producto=p.id and p.lleva_stock=1 and cantidad<=p.punto_pedido group by p.nombre, p.marca, p.unidad_medida,p.stock_minimo,p.punto_pedido,p.stock_maximo,s.id_producto, p.tipo_producto_id order by p.nombre asc;",[]);
    return view('stock_punto_pedido',['stock'=>$stock]);
})->name('stock_punto_pedido');




Route::get('/saldos_bajo_punto_pedido_pdf/', function () {
	$stock = DB::select("select p.nombre, p.marca, p.unidad_medida,p.stock_minimo,p.punto_pedido,p.stock_maximo,s.id_producto, p.tipo_producto_id,sum(cantidad) as cantidad from saldos s, productos p where s.id_producto=p.id and p.lleva_stock=1 and cantidad<=p.punto_pedido group by p.nombre, p.marca, p.unidad_medida,p.stock_minimo,p.punto_pedido,p.stock_maximo,s.id_producto, p.tipo_producto_id order by p.nombre asc;",[]);
	$matriz=array();
	
	foreach ($stock as $p) {
		$matriz[$p->id_producto]['nombre']=$p->nombre;
		$matriz[$p->id_producto]['marca']=$p->marca;
		$matriz[$p->id_producto]['unidad_medida']=$p->unidad_medida;
		$matriz[$p->id_producto]['stock_min']=number_format ( $p->stock_minimo, 2, "," , "." );
		$matriz[$p->id_producto]['pto_ped']=number_format ( $p->punto_pedido, 2, "," , "." );
		$matriz[$p->id_producto]['saldo']=number_format ( $p->cantidad,2, "," , "." );
		
			

	}
	
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->Image('images/rincon.jpeg',180,6,15,15);
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,"Stock bajo de Punto de Pedido");
	$pdf->Ln();
	$pdf->SetFont('Arial','',11);
	$pdf->Write(5,"Fecha:".date("d/m/Y",time()));
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$cols=array();$aligns=array();
	$cols[]=65;$titulos[]="Producto";$aligns[]="L";
	$cols[]=30;$titulos[]="Marca";$aligns[]="L";
	$cols[]=20;$titulos[]="U.M.";$aligns[]="C";
	$cols[]=20;$titulos[]="Stock Minimo";$aligns[]="R";
	$cols[]=20;$titulos[]="Punto de Pedido";$aligns[]="R";
	$cols[]=30;$titulos[]="Stock Actual";$aligns[]="R";


	$pdf->SetWidths($cols);$pdf->SetAligns($aligns);
	$pdf->Row($titulos);

	foreach($matriz as $m){

		$row=array($m['nombre']);
		$row[]=$m['marca'];
		$row[]=$m['unidad_medida'];
	    $row[]=$m['stock_min'];
		$row[]=$m['pto_ped'];
	    $row[]=$m['saldo'];
	    $pdf->Row($row);
	}

	$pdf->Output("D","stock_bajo_pedido.pdf");	

})->name('saldos_bajo_punto_pedido_pdf');


Route::get('/productos_sin_stock_seleccion', function () {

	$agrupacion = array("Productos para la Venta","Materias Primas e Insumos");
    return view('/productos_sin_stock_seleccion',['agrupacion'=>$agrupacion]);
})->name('productos_sin_stock_seleccion');




Route::post('/productos_sin_stock_seleccion', function () {


	$titulo=$_POST['grupo'];


	if ($_POST['grupo']=="Productos para la Venta") {
		$g=1;
		$saldos=DB::select("select p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre as tipo_producto, sum(cantidad) as cantidad from productos p left join saldos s on p.id=s.id_producto, tipo_producto t where p.tipo_producto_id not in (4,7) and t.id=p.tipo_producto_id and (cantidad=0 or cantidad is null) group by p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre ",[]);}
	else{
		$g=2;
		$saldos=DB::select("select p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre as tipo_producto, sum(cantidad) as cantidad from productos p left join saldos s on p.id=s.id_producto, tipo_producto t where p.tipo_producto_id in (4,7) and t.id=p.tipo_producto_id and (cantidad=0 or cantidad is null) group by p.codigo,p.nombre, p.marca, p.unidad_medida, s.id_producto, t.nombre ",[]);
	}


		return view('productos_sin_stock',['saldos'=>$saldos, 'titulo'=>$titulo,'grupo'=>$g]);	
})->name('productos_sin_stock');




Route::get('/control_vencimientos_seleccion', function () {

	$agrupacion = array("Productos para la Venta","Materias Primas e Insumos");
    return view('/control_vencimientos_seleccion',['agrupacion'=>$agrupacion]);
})->name('control_vencimientos_seleccion');




Route::post('/control_vencimientos_seleccion', function () {


	$titulo=$_POST['grupo'];


	if ($_POST['grupo']=="Productos para la Venta") {
		$g=1;
		$saldos=DB::select("select s.depositos_id, s.deposito, s.lote, s.vencimiento, p.id as codigo,p.nombre, p.marca, p.unidad_medida, t.nombre as tipo, sum(cantidad) as total from vista_movimientos s, productos p, tipo_producto t where s.productos_id=p.id and p.tipo_producto_id=t.id and t.id not in (4,7) group by s.depositos_id, s.deposito, s.lote, s.vencimiento, p.id,p.nombre, p.marca, p.unidad_medida, t.nombre having sum(cantidad)>0 order by s.vencimiento asc ",[]);}
	else{
		$g=2;
		$saldos=DB::select("select s.depositos_id, s.deposito, s.lote, s.vencimiento, p.id as codigo, p.nombre, p.marca, p.unidad_medida, t.nombre as tipo, sum(cantidad) as total from vista_movimientos s, productos p, tipo_producto t where s.productos_id=p.id and p.tipo_producto_id=t.id and t.id in (4,7)  group by s.depositos_id, s.deposito, s.lote, s.vencimiento, p.id, p.nombre, p.marca, p.unidad_medida, t.nombre  having sum(cantidad)>0 order by s.vencimiento asc",[]);
	}


		return view('control_vencimientos',['saldos'=>$saldos, 'titulo'=>$titulo,'grupo'=>$g]);	
})->name('control_vencimientos');

