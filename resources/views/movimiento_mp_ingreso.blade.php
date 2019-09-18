@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Movimientos</h1>
          <p class="mb-4">Ingreso de Materias Primas</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><b> {{$producto->nombre}}</b></h6>
            </div>
            <div class="card-body">
 <form class="user" action="{{ url('/movimiento_mp_ingreso') }}" id=movimiento_mp_ingreso method=POST>
      @csrf

          <!--div class="form-group row"> 
              <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="tipo_prod">Producto</label>
                 <p>{{$producto->nombre}}</p>
              </div>
          </div-->

         <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <input class="form-control" type="text" placeholder="Numero de Lote" name=lote_numero>
            </div>
            <div class="col-sm-3">
              <input class="form-control" type="text" placeholder="Fecha Vencimiento" name=lote_fechavencimiento>
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
               <input class="form-control" type="text" placeholder="Cantidad" name=movimiento_cantidad>
            </div>
        </div>
         
         <div class="form-group row"> 
              <div class="col-sm-6 mb-3 mb-sm-0">
                 <label for="tipo_prod">Deposito</label>
                 <select class="form-control"  name=movimiento_deposito>
                 @foreach ($depositos as $p)
                  <option value={{$p->id}}>{{$p->nombre}}</option>
                @endforeach
              </select>
              </div>
          </div>
          <div class="form-group row"> 
              <div class="col-sm-6 mb-3 mb-sm-0">           
                  <label for="stkmin">Comprobante asociado</label>
                  <input class="form-control" type="text" placeholder="" name=movimiento_comprobante_asociado>
              </div>
               <div class="col-sm-6 mb-3 mb-sm-0"> 
                <label for="stkmax">Observaciones</label>
                <input class="form-control" type="text" placeholder=""  name=movimientos_observaciones>
              </div>
            </div>

       <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
              <a href="#"  onclick="document.getElementById('nuevo_prod').submit();" class="btn btn-success btn-icon-split">
               <span class ="icon text-white-50">
                          <i class="fas fa-check-double"></i>
               </span>
               <span class="text">Crear movimiento</span>
              </a>
            </div>
          </div>     
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection