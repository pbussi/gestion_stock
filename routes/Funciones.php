<?php

function talonarioSiguiente($tipo){

	DB::select('update talonario set ultimo_usado=ultimo_usado+1 where tipo=?',[$tipo]);
	$ultimo = DB::select('select ultimo_usado from talonario where tipo=?',[$tipo]);
	return $tipo.str_pad($ultimo[0]->ultimo_usado,6,"0", STR_PAD_LEFT);

}

