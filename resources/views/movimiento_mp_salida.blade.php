@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Movimientos</h1>
          <p class="mb-4">Egreso de Materias Primas e Insumos</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><b> {{$producto->nombre}}</b></h6>
            </div>
      <div class="card-body">
 <form class="user" action="{{ url('/movimiento_mp_salida') }}" id=movimiento_mp_salida method=POST>
      @csrf
        <input type=hidden name=id value="{{$producto->id}}">
        <div class="form-group row ">
            <div class="col-sm-3 mb-3 mb-sm-0">
               <label for="fecha_mov">Fecha de Salida</label>
              <input class="form-control" type="date" name=fecha_movimiento value="{{ date('d-m-Y') }}">
            </div>

        </div>

          <div class="form-group row">
 

              <div class="col-sm-12 mb-6 mb-sm-0">  
                <br>
                <label>Seleccione el deposito y lote a descargar</label>
                <table class="table table-striped dataTable">
                  <thead>
                    <tr>
                    <Th> </Th>
                    <th>DEPOSITO</th>
                      <th>LOTE Nro.</th>
                      <th>VENCIMIENTO</th>
                      <th>SALDO</th>
                     
                   </tr>
                  </thead>
                  <?php $primero=true; ?>
                @foreach ($saldos as $p)
                  <tr>
                    <td><input type="radio" name=stock_deposito <?php if ($primero){$primero=false; echo "checked";} ?> value={{$p->id_lote_mp}}-{{$p->id_lote_produccion_id}}-{{$p->id_deposito}}-{{ $p->saldo }}></td>
                    <td>{{$p->nombre_deposito}}</td>
                    <td>{{ $p->numero_lote }}</td> 
                     <td>{{ date('d-m-Y', strtotime($p->vencimiento))}}</td> 
                    <td class="text-info"> {{ $p->saldo }} {{ $producto->unidad_medida }}</td>
                   
                    
                  </tr>
                @endforeach
              </table>

              </div>
        </div>

      <div class="form-group row"> 
          <br><br>
          <div class="col-sm-3 mb-3 mb-sm-0">
               <label for="movimiento_cantidad">Cantidad a Descargar</label>
               <input class="form-control text-danger" type="text" name=movimiento_cantidad style="font-weight: bold;">
          </div>
          <div class="col-sm-2 mb-3 mb-sm-0">
              <label for="unidad_medida">Unidad de Medida</label>   
               <input class="form-control" type="text" name=unidad_medida readonly="readonly" placeholder="{{ $producto->unidad_medida }}">
          </div>  
           <div class="col-sm-4 mb-3 mb-sm-0">
                 <label for="tipo_prod">Destino</label>
                 <select class="form-control"  name=destino>
                 @foreach ($destinos as $d)
                  <option value={{$d->id}}>{{$d->nombre}}</option>
                @endforeach
              </select>
              </div> 
     </div>
      <div class="form-group row"> 

          <div class="col-sm-5 mb-3 mb-sm-0"> 
                <label for="stkmax">Observaciones</label>
                <input class="form-control" type="textarea" placeholder=""  name=movimientos_observaciones>
          </div>

             
         

       </div>

       <div class="form-group row"> 
            <div class="col-sm-4 mb-3 mb-sm-0">
              <a href="#"  onclick="document.getElementById('movimiento_mp_salida').submit();" class="btn btn-success btn-icon-split">
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