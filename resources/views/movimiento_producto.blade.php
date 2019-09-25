@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Movimientos de Productos</h1>
          <p class="mb-4">Ingresos y Egresos registrados</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><b> {{$producto->nombre}}</b></h6>
            </div>
      <div class="card-body">
         <?php $pos=1 ?>
   @foreach ($movimientos as $dep =>$movs)

      <div class="form-group row ">
              <div class="col-sm-12 mb-3 mb-sm-0 card border-left-info">
                <p></p>
                <h5 class="text-info font-weight-bold text-uppercase mb-4"> {{ $dep }} </h5>
                <table  class="table  table-striped small" id="dataTable_<?php print $pos++ ?>" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Fecha</th>
                         <th>Tipo movimiento</th>
                        <th>Lote</th>
                        <th>Vencimiento</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                  </thead>
                 <?php $subtotal=0 ?>
                 @foreach ($movs as $mov)
                <tr><td>{{date('d-m-Y', strtotime($mov->fecha)) }}</td>
                  <td> @if ($mov->cantidad<0) Egreso @else Ingreso @endif </td>
                  <td>{{$mov->lote }}</td><td>{{date('d-m-Y', strtotime($mov->vencimiento)) }}</td>
                  <td  @if ($mov->cantidad<0) class='text-danger' @endif ><b>{{$mov->cantidad }}</b></td>
                    <td><?php $subtotal=$subtotal+$mov->cantidad; print $subtotal ?></td></tr>
                <script>// Call the dataTables jQuery plugin
                $(document).ready(function() {
                  $('#dataTable_<?php print $pos ?>').DataTable({
                  "orderMulti": false
                });
                });
                </script>
                @endforeach
                 <tfoot>
                    <tr>
                        <th></th>
                         <th></th>
                        <th></th>
                        <th></th>
                        <th align="right">Saldo: </th>
                        <th class='text-info font-weight-bold'>{{ $saldosxdep[$mov->depositos_id]['saldo'] }}</th>
                    </tr>

                </table>
              </div>
    </div>
   @endforeach


 <!--<form class="user" action="{{ url('/movimiento_mp_salida') }}" id=movimiento_mp_salida method=POST>
      @csrf
        <input type=hidden name=id value="{{$producto->id}}">
        <div class="form-group row ">
            <div class="col-sm-2 mb-3 mb-sm-0">
               <label for="fecha_mov">Fecha de Salida</label>
              <input class="form-control" type="date" name=fecha_movimiento value="{{ date('Y-m-d') }}">
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
                      <th>SALDO</th>
                      <th>Movimientos</th>
                   </tr>
                  </thead>
                @foreach ($saldos as $p)
                  <tr>
                    <td><input type="radio" name=stock_deposito value={{$p->id_lote}}-{{$p->id_deposito}}-{{ $p->saldo }}></td>
                    <td>{{$p->nombre_deposito}}</td>
                    <td>{{ $p->numero_lote }}</td> 
                    <td class="text-info"> {{ $p->saldo }} {{ $producto->unidad_medida }}</td>
                    <td> <a href="{{ url('/movimientos',$producto->id) }}" class="float-left">
                        <span class="icon">
                          <i class="fas fa-edit"></i>
                        </span>
                      </a></td>
                    
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
     </div>
      <div class="form-group row"> 
          <div class="col-sm-3 mb-3 mb-sm-0">           
                  <label for="movie
                  ">Comprobante asociado</label>
                  <input class="form-control" type="text" placeholder="" name=movimiento_comprobante_asociado>
          </div>
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
-->
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection