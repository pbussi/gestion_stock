
@extends('layout')

@section('content')
  <script src=http://localhost/proyecto/gestion_stock/public/vendor/jquery/jquery.min.js></script>
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Remito  Nro.<B> <?php echo "REM".str_pad($venta->id,6,"0", STR_PAD_LEFT); ?></B> </h1>


   
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0  text-primary mb-2 mt-2"> <i>Fecha del Comprobante:     </i><?php echo date('d/m/Y', strtotime($venta->fecha)); ?><br>
           <i>Cliente:  </i><p class="m-0 text-info font-weight-bold text-uppercase mb-2 mt-2" style="font-size:20px;"><?php echo $venta->razon_social; ?></p>
           <i>Lista de precios:  </i><?php echo $venta->lista_precios; ?>

           <a href="{{ url('/venta_pdf',$venta->id) }}" class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
              <span class="icon text-white-50">
                  <i class="fas fa-print"></i>
              </span>
              <span class="text">Imprimir</span>
            </a>
          </h6>
        </div>
      </div>
 
        <div class="card-body">
         <div class="table-responsive">
          <table class="table table-bordered small" id="xxdataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th scope="col">Codigo</th>
              <th scope="col">Producto</th>
              <th scope="col">U.M.</th>
              <th scope="col">Cant. Pedida</th>
              <th scope="col">Cant. a Facturar</th>
              <th scope="col">Precio Unitario</th>
              <th scope="col">Total</th>
              <th scope="col">Reservar</th>
              <th scope="col">Sin asignar</th>
              <th class="w-10"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($item_pedidos as $i)
            <tr>
              <td>{{ $i->codigo }}</td>
              <td>{{ $i->nombre }}</td>
               <td>{{ $i->unidad_medida}}</td>
              <td> {{ $i->cantidad }}</td>
              <td>  calc</td>
              <td align="right">$ {{ $i->precio}}</td>
              <td align="right">$ {{ $i->cantidad * $i->precio }}</td>
              <td>
                @if (count($asignaciones[$i->id])>0)
                  @foreach ($asignaciones[$i->id] as $a)
                      @if (($a->cantidad)<>0)
                         <p> L:{{$a->lote}}: {{$a->cantidad}} </p>
                      @endif
                  @endforeach
                    <a href="#" onclick="if (confirm('Desea quitar la asignacion de estos productos. Se eliminarán los moviminetos'))  window.location.href='{{ url('/desasignar_lotes_venta',$venta->id) }}/{{$i->id}}'">
                      <i class="fas fa-ban fa-2x text--300" ></i>
                    </a>
                @else
                <i class="fas fa-edit fa-2x text--300" data-toggle="modal" data-target="#info_asignacion_{{$i->id}}"></i>
                @endif
              </td>
              <td class="w-10"> 
                         <a href="{{url('/desasignar_lotes_venta',$venta->id) }}/{{$i->id}}?borrar" class="float-left">
                        <span class="icon">
                          <i class="fas fa-trash"></i> 
                        </span>
                      </a> 
                      </td>
            </tr>
            @endforeach
          </tbody>
         </table>
        </div>
      </div>  <!--div card-body -->

    

<!-- Modales info -->
@foreach ($item_pedidos as $i)
<div class="modal fade" id="info_asignacion_{{$i->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title text-info font-weight-bold text-uppercase mb-3" id="exampleModalLongTitle">Lotes disponibles {{$i->nombre}}</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method=POST action="{{url('/asignar_lotes_venta',$venta->id)}}" id="asignar_lotes_venta_{{$i->id}}">
           @csrf
         <div class="table-responsive"> 
           <?php $subtotal=$i->cantidad; ?>
                <input type=hidden name=precio value="{{$i->precio}}">
             <table class="table table-bordered small" width="100%" cellspacing="0">
                <tr>
                   <th scope="col">Nro. Lote</th>
                   <th scope="col">Fecha Vencimiento</th>
                   <th scope="col">Saldo</th>
                   <th scope="col">Depósito</th>
                   <th scope="col" style="text-align:center;">Asignar</th>
                </tr>
               
               @foreach ($lotes_disponibles[$i->id] as $l)
                <tr>
                  <td>{{$l->numero_lote}}</td>
                  <td>{{ date('d-m-Y', strtotime($l->vencimiento))}}</td> 
                   <td>{{$l->saldo}}</td>
                   <td>{{$l->nombre_deposito}}</td>
                   <td width=10%><input type=text  size=5 style="size=1, text-align: right;" name=asignar[{{$l->id_deposito}},{{$l->id_lote_mp}},{{$l->id_lote_produccion_id}}]
                    value=<?php 
                      if ($subtotal>0) {
                        if ($l->saldo<=$subtotal) {
                          echo $l->saldo;$subtotal-=$l->saldo;
                        }else{
                          echo $subtotal;$subtotal=0;
                        } 
                      } else echo 0;
                    ?>></td>
                </tr>
               @endforeach
             </table>
          </div>
         <p>Diferencia: <?php echo($subtotal); ?> </p>
         <p>Cantidad Pedida: {{$i->cantidad}} </p>
          <a href="#" onclick="document.getElementById('asignar_lotes_venta_{{$i->id}}').submit();" class="btn btn-success btn-icon-split float-right">
                     <span class ="icon text-white-50">
                     <i class="fas fa-archive"></i>
                      </span>
                      <span class="text">Asignar</span></a>
          </form>
      </div>
  </div>
</div>
@endforeach



<form action="{{ url('/venta_gestion_nuevo_item',$venta->id) }}" id=nuevo_item_venta method=POST>
<div class="form-group row">
      @csrf
        <div class="col-sm-3 mb-3 mb-sm-0">
          <label for="lote_numero">Producto</label>
             <select class="form-control"  name=producto id=producto>
               <option value=0 >Elija producto</option>
               @foreach ($productos as $p)
                <option value={{$p->id}}>{{$p->nombre}}</option>
              @endforeach
            </select>
        </div>
        
        <div class="col-sm-1 mb-3 mb-sm-0">
          <label for="u">Cantidad</label>   
          <input class="form-control" type="text" name=cantidad id=cantidad >

        </div>
        <div class="col-sm-1 mb-3 mb-sm-0">
          <label for="u"></label>
            <a href="#"  onclick="
                  if (!(parseFloat($('#cantidad').val())>0)){
                    alert('Ingrese cantidad');
                    return;
                  }
                   document.getElementById('nuevo_item_venta').submit();"
                  class="btn btn-success btn-icon-split" style="margin-top: 7px;">
            <span class ="icon text-white-50">
                <i class="fas fa-check-double"></i>
            </span>
            <span class="text">Agregar</span></a>
        </div>
  
</div>
</form>      <!-- /.container-fluid -->

</div>



@endsection