<?php

Route::get('/clientes', function () {
	if (isset($_GET['borrar']))
	{
		try{
		DB::select('delete from clientes where id=?',[$_GET['borrar']]);
		}
		catch (Exception $e){
			return redirect()->route('clientes')->with('error',"No se puede eliminar el cliente.  Existen movimientos asociados");
		}
	return redirect()->route('clientes')->with('success','El cliente ha sido eliminado');


	}




	$clientes = DB::select('select * from clientes');

    return view('clientes', ['clientes' => $clientes]);
})->name('clientes');


Route::get('/clientes_pdf', function () {
	
	$clientes = DB::select("select c.id, c.razon_social, c.cuit, c.localidad, c.direccion, c.telefono, c.provincia, c.lista_precios_id, c.mail, c.situacion_iva, s.situacion, l.nombre as nombre_lista  from clientes c, lista_precios l, situacion_IVA s where c.lista_precios_id=l.id and c.situacion_iva=s.id");
	
	$matriz=array();
	foreach ($clientes as $c) {
		$matriz[$c->id]['codigo']=$c->id;
		$matriz[$c->id]['razon_social']=$c->razon_social;
		$matriz[$c->id]['cuit']=$c->cuit;
		$matriz[$c->id]['situacion_iva']=$c->situacion;
		$matriz[$c->id]['direccion']=$c->direccion;
		$matriz[$c->id]['localidad']=$c->localidad;		
		$matriz[$c->id]['provincia']=$c->provincia;		
		$matriz[$c->id]['telefono']=$c->telefono;	
		$matriz[$c->id]['mail']=$c->mail;
		$matriz[$c->id]['lista_asociada']=$c->nombre_lista;					
		
	}
	
    require('mc_table.php');
	$pdf=new PDF_MC_Table();
    $pdf->AddPage('L', 'A4');
	$pdf->SetFont('Arial','',12);
	$pdf->Write(5,"Listado de Clientes Heladeria Rincon.  Fecha:".date("d/m/Y",time()));

	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$cols=array(10);$titulos=array("");$aligns=array("L");
	



	$cols[]=40;$titulos[]="Razon Social";$aligns[]="L";
	$cols[]=35;$titulos[]="Situacion IVA";$aligns[]="L";
	$cols[]=30;$titulos[]="Direccion";$aligns[]="L";
	$cols[]=30;$titulos[]="Localidad";$aligns[]="L";
	$cols[]=30;$titulos[]="Provincia";$aligns[]="L";
	$cols[]=20;$titulos[]="Telefono";$aligns[]="L";
	$cols[]=40;$titulos[]="mail";$aligns[]="L";
	$cols[]=45;$titulos[]="Lista Asociada";$aligns[]="L";
	
	
	
	

	$pdf->SetWidths($cols);$pdf->SetAligns($aligns);
	$pdf->Row($titulos);

	foreach($matriz as $m){

		$row=array($m['codigo']);

		$row[]=$m['razon_social'];
		$row[]=$m['situacion_iva'];
		$row[]=$m['direccion'];
		$row[]=$m['localidad'];
		$row[]=$m['provincia'];
		$row[]=$m['telefono'];
		$row[]=$m['mail'];
		$row[]=$m['lista_asociada'];


		
		
	
	    $pdf->Row($row);
	}

	
	$pdf->Output("D","clientes.pdf");
})->name('clientes_pdf');


Route::get('/cliente_nuevo', function () {
	$lista_precios=DB::select('select * from lista_precios');
	$situacion_iva= DB::select("select * from situacion_IVA");
    return view('cliente_nuevo',['lista_precios'=>$lista_precios, 'situacion_iva'=>$situacion_iva]);

})->name('cliente_nuevo');

Route::post('/cliente_nuevo', function () {

	DB::select('insert into clientes values (NULL,?,?,?,?,?,?,?,?,?,?)',[$_POST['cuit'],$_POST['razon_social'],$_POST['situacion_iva'],$_POST['direccion'],$_POST['telefono'],$_POST['localidad'],$_POST['provincia'],$_POST['mail'],$_POST['lista'],$_POST['observaciones']]);
	
    return redirect()->route('clientes')->with('success','El cliente ha sido creado!');
});



Route::get('/cliente_edit/{id}', function ($id) {

	$lista_precios= DB::select('select * from lista_precios');
	$situacion_iva= DB::select("select * from situacion_IVA");
	$cliente = DB::select('select *from clientes where id=?',[$id]);
	$lista_cliente=DB::select('select lista_precios_id from clientes where id=?',[$id]);
	$cliente = $cliente[0];
	
    return view('cliente_edit',['cliente' => $cliente, 'lista_precios'=>$lista_precios, 'situacion_iva'=>$situacion_iva]);
});


Route::post('/cliente_edit', function () {
	
	$cliente = DB::select('update clientes set cuit=?,razon_social=?,situacion_iva=?, direccion=?,telefono=?,localidad=?,provincia=?,mail=?,lista_precios_id=?, observaciones=? where id=?',[$_POST['cuit'],$_POST['razon_social'], $_POST['situacion_iva'], $_POST['direccion'],$_POST['telefono'],$_POST['localidad'],$_POST['provincia'],$_POST['mail'],$_POST['lista'],$_POST['observaciones'],$_POST['id']]);

   return redirect()->route('clientes')->with('success','Cliente actualizado!');   
});
