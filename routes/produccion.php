<?php



Route::get('/lotes_produccion', function () {
	$lotes=DB::select('select * from lotes_produccion order by fecha desc',[]);
	
    return view('lotes_produccion',['lotes' => $lotes]);
})->name('lotes_produccion');;


Route::get('/lote_produccion_nuevo', function () {
    return view('lote_produccion_nuevo', []);
})->name('lote_produccion_nuevo');

Route::post('/lote_produccion_nuevo', function () {

	$past_temp=$_POST['pasteurizacion_temperatura'];
	$past_tiempo=$_POST['pasteurizacion_tiempo'];
	$observaciones=$_POST['observaciones'];

	if ($_POST['pasteurizacion_temperatura']=="" )
			$past_temp=NULL;
	if ($_POST['pasteurizacion_tiempo']=="" )
			$past_tiempo=NULL;
	if ($_POST['observaciones']=="" )
			$observaciones=NULL;
    DB::select("insert into lotes_produccion values (NULL,?,?,?,?,?,1)",[$_POST['fecha_lote'],$_POST['base'],$past_temp,$past_tiempo,$observaciones]);	
	$id = DB::getPdo()->lastInsertId();
	return redirect()->route('lotes_produccion_gestion',$id)->with('success',"El lote $id se ha creado correctamente.");

})->name('lote_produccion_nuevo');

Route::get('/lote_produccion_cambiar_estado/{id}', function ($id) {
	DB::select('update lotes_produccion set estado=not estado where id=?',[$id]);
})->name('lote_produccion_cambiar_estado');


Route::get('/lotes_produccion_gestion/{id}', function ($id) {
	if (isset($_GET['borrar'])){
		DB::select('delete from mp_lote_produccion where movimiento_id=?',[$_GET['borrar']]);
		DB::select('delete from movimientos where id=?',[$_GET['borrar']]);
	}
	if (isset($_GET['borrar_mp'])){
		DB::select('delete from mp_lote_produccion where id=?',[$_GET['borrar_mp']]);
	}
	if (isset($_GET['asignar_mp'])) {
		DB::select('update mp_lote_produccion set id_lote_prod_terminado=? 
			where id=?',[$_GET['p_l_p'],$_GET['asignar_mp']]);

	}
	$lote=DB::select('select * from lotes_produccion where id=?',[$id]);
	$productos=DB::select('select * from productos where tipo_producto_id in (4,7)');
	$lote = $lote[0];
	$ingredientes=DB::select('select *,lp.id as lp_id from mp_lote_produccion lp,lotes_mp mp,productos p where lotes_prod_id=? and lp.lotes_mp_id=mp.id and mp.productos_id=p.id',[$id]);
	$terminados=DB::select("select p.*,l.id as pt_id from productos p,productos_lote_produccion l where l.productos_id=p.id and l.lotes_produccion_id=?",[$id]);
    return view('lotes_produccion_gestion', ['ingredientes'=>$ingredientes,'lote'=>$lote,'productos'=>$productos, 'terminados'=>$terminados]);
})->name('lotes_produccion_gestion');

Route::get('/lotes_produccion_gestion_info/{id}', function ($id) {
	
	if (isset($_GET['pasteurizacion_temperatura'])){
		DB::select('update lotes_produccion set pasteurizacion_temperatura=?  where id=?',[$_GET['pasteurizacion_temperatura'],$id]);
	}
	if (isset($_GET['pasteurizacion_tiempo'])){
		DB::select('update lotes_produccion set pasteurizacion_tiempo=?  where id=?',[$_GET['pasteurizacion_tiempo'],$id]);
	}
	if (isset($_GET['observaciones'])){
		DB::select('update lotes_produccion set observaciones=?  where id=?',[$_GET['observaciones'],$id]);
	}

	if (isset($_GET['base'])){
		DB::select('update lotes_produccion set base=?  where id=?',[$_GET['base'],$id]);
	}
	$lote=DB::select('select * from lotes_produccion where id=?',[$id]);
	$lote = $lote[0];	
	$bases=array("Blanca","Chocolate","Dulce de Leche");
	
    return view('lotes_produccion_gestion_info', ['lote'=>$lote, 'bases'=>$bases]);
})->name('lotes_produccion_gestion_info');



Route::get('/lotes_produccion_gestion_terminados/{id}', function ($id) {
	if (isset($_GET['borrar'])){
		DB::select('update mp_lote_produccion set id_lote_prod_terminado=NULL where id_lote_prod_terminado=?',[$_GET['borrar']]);
		DB::select('delete from movimientos where productos_lote_produccion_id=?',[$_GET['borrar']]);
		DB::select('delete from productos_lote_produccion where id=?',[$_GET['borrar']]);
		
	}
	$lote=DB::select('select * from lotes_produccion where id=?',[$id]);
	$lote = $lote[0];
	$productos=DB::select('select * from productos where tipo_producto_id in (1,2,3,8)');
	
	$terminados=DB::select("select p.*,pt.cantidad,pt.id as pt_id from productos p,productos_lote_produccion pt where pt.productos_id=p.id and pt.lotes_produccion_id=?",[$id]);

    return view('lotes_produccion_gestion_terminados', ['lote'=>$lote,'productos'=>$productos, 'terminados'=>$terminados]);
})->name('lotes_produccion_gestion_terminados');




Route::post('/lotes_produccion_gestion/{id}', function ($id) {
	// Primero buscamos si el producto no lleva stock
	// si no lleva stock, buscamos o creamos un lote con el texto "Producto no trazado" y lo tomamos como id de lote
	// si lleva stock, tomamos como id de lote el recibido
	$prod=DB::select("select * from productos where id=?",[$_POST['producto']]);
	$prod=$prod[0];
	if ($prod->lleva_stock==0){  // el producto no lleva stock, generamos el id de lote
		$reg=DB::select("select * from lotes_mp where productos_id=? and numero='Producto no trazado'",[$_POST['producto']]);
		if (count($reg)>0){   // encontramos el lote generico
			$id_lote=$reg[0]->id;
		} else {  // no encontramo el lote generico, lo creamos
			DB::select("insert into lotes_mp values (NULL,'Producto no trazado',now(),?)",[$_POST['producto']]);
			$id_lote = DB::getPdo()->lastInsertId();
		}
		$mov=DB::select('insert into mp_lote_produccion values (NULL,?,?,NULL,NULL,?)',[$id,$id_lote,$_POST['cantidad']]);	
	} else{ //el producto lleva stock, usamos el que se recibe (esta controlada la cantidad)
		$id_lote = $_POST['lote'];
		$mov=DB::select("insert into movimientos values (NULL,NOW(),?,?,'',?,NULL,?)",[-$_POST['cantidad'],$_POST['deposito'],$id_lote,"PROD".str_pad($id,6,"0", STR_PAD_LEFT)]);	
		$id_movimiento = DB::getPdo()->lastInsertId();
		$mov=DB::select('insert into mp_lote_produccion values (NULL,?,?,?,NULL,?)',[$id,$id_lote,$id_movimiento,$_POST['cantidad']]);	
	}
    return redirect()->route('lotes_produccion_gestion',$id)->with('success','Item agregado!');
})->name('lotes_produccion_gestion_post');

Route::post('/lotes_produccion_gestion_terminados/{id}', function ($id) {
	// primero damos de alta el movimiento siempre al deposito CAMARA
	//luego lo damos de alta en la table productos_lote_produccion
	$deposito=12; //CAMARA
	$mov=DB::select('insert into productos_lote_produccion values (NULL,?,?,?)',[$_POST['producto'],$id,$_POST['cantidad']]);	
	$id_producto_terminado = DB::getPdo()->lastInsertId();
	$mov=DB::select("insert into movimientos values (NULL,NOW(),?,?,'',NULL,?,?)",[$_POST['cantidad'],$deposito,$id_producto_terminado,"PROD".str_pad($id,6,"0", STR_PAD_LEFT)]);	
		
		
    return redirect()->route('lotes_produccion_gestion_terminados',$id)->with('success','Item agregado!');
})->name('lotes_produccion_gestion_post');




Route::get('/lotes_produccion_pdf/{id}', function ($id) {
	$lote=DB::select('select * from lotes_produccion where id=?',[$id]);
	$lote = $lote[0];	
	$terminados=DB::select("select p.*,pt.cantidad,pt.id as pt_id from productos p,productos_lote_produccion pt where pt.productos_id=p.id and pt.lotes_produccion_id=?",[$id]);
	$ingredientes=DB::select('select *,lp.id as lp_id from mp_lote_produccion lp,lotes_mp mp,productos p where lotes_prod_id=? and lp.lotes_mp_id=mp.id and mp.productos_id=p.id',[$id]);
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	//$pdf->Image('images/rincon.jpeg',175,6,15,15);
	$pdf->SetFont('Arial','',15);
	$pdf->SetFillColor(0, 0, 0);
	$pdf->SetTextColor(255,255,255);

	$pdf->Cell(180, 10, "PLANILLA DE ELABORACION DE HELADOS", 0, 0, 'C', true);
	$pdf->SetTextColor(0,0,0);
	//$pdf->Write(5,"PLANILLA DE ELABORACION DE HELADOS",'',1,'R');
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell(180, 10, "LOTE PROD".str_pad($id,6,"0", STR_PAD_LEFT). "    -   FECHA DE PRODUCCION: " .date("d/m/Y",strtotime($lote->fecha)), 0, 0, 'C', true);
	$pdf->Ln();

	$pdf->Cell(180, 10, "BASE:". strtoupper($lote->base));
	$pdf->Ln();	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(180, 10, "Observaciones:". strtoupper($lote->observaciones));
	$pdf->Ln();
	$pdf->SetWidths(array(60,30,30,30,30));//$pdf->SetAligns($aligns);
	//$pdf->SetCellHeight(10);
	$pdf->SetFont('Arial','',12);
	$pdf->Row(array("PASTEURIZACION ","Temperatura: ", $lote->pasteurizacion_temperatura.utf8_decode(" °C"),"Tiempo: ",$lote->pasteurizacion_tiempo . " Min."));

    $pdf->Ln();	$pdf->Ln();
	$pdf->Write(5,"Ingredientes",'',1,'R');
	$pdf->Ln();$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetWidths(array(70,30,40,20,20));
	$pdf->SetAligns(array('L','L','L','C','C'));
	$pdf->Row(array("Nombre ","Marca", "Lote","U.M","Cantidad"));
	$pdf->SetAligns(array('L','L','L','C','R'));
	foreach ($ingredientes as $i){
		$pdf->Row(array($i->nombre,$i->marca,$i->numero,$i->unidad_medida,$i->cantidad));
	}

	$pdf->Ln();	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Write(5,"Cantidad de Baldes Terminados",'',1,'R');
	$pdf->Ln();$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetAligns(array('L','C'));
	$pdf->SetWidths(array(70,20));
	$pdf->Row(array("Producto ","Cantidad"));
	$pdf->SetAligns(array('L','R'));
	foreach ($terminados as $t){
		$pdf->Row(array($t->nombre,$t->cantidad));
	}

	$pdf->Output("I","plan_produccion.pdf");
	die;
})->name('lotes_produccion_pdf');