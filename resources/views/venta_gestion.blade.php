
@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Remito  Nro.<B> <?php echo "REM".str_pad($venta->id,6,"0", STR_PAD_LEFT); ?></B> </h1>


   <script type="text/javascript"> pendientes_asignacion=0;</script>

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0  text-primary mb-2 mt-2"> <i>Fecha del Comprobante:     </i><?php echo date('d/m/Y', strtotime($venta->fecha)); ?><br>
           <i>Cliente:  </i><p class="m-0 text-info font-weight-bold text-uppercase mb-2 mt-2" style="font-size:20px;"><?php echo $venta->razon_social; ?></p>
           <i>Lista de precios:  </i><?php echo $venta->lista_precios; ?>

            <h4 class="small font-weight-bold mt-3" style="width: 50%">Estado del Pedido:  @if($venta->estado==0) Abierto <span class="float-right">10%</span></h4>
            <div class="progress mb-3" style="width:50%">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>

            @else 
              @if ($venta->estado==1) En Preparacion <span class="float-right">60%</span></h4> <div class="progress mb-3" style="width:50%">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              @else
                  Enviado <span class="float-right">100%</span></h4>
                  <div class="progress mb-3" style="width:50%">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              @endif
          @endif
         </i> </h5>
          @if ($venta->estado==1){
           <a href="{{ url('/remitos_pdf',$venta->id) }}" class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
              <span class="icon text-white-50">
                  <i class="fas fa-print"></i>
              </span>
              <span class="text">Imprimir</span>
            </a>
          @endif
           @if ($venta->estado==2){
           <a href="{{ url('/remitos_pdf',$venta->id) }}" class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
              <span class="icon text-white-50">
                  <i class="fas fa-print"></i>
              </span>
              <span class="text">Imprimir</span>
            </a>
          @endif

            @if ($venta->estado==0 and $item_pedidos!=null)          
              <a href="{{ url('/venta_cambiar_estado',$venta->id) }}?estado=1" class=" btn btn-info btn-icon-split float-right" style="margin-left: 10px;">
                <span class="icon text-white-50">
                    <i class="fas fa-cogs"></i>
                </span>
                <span class="text">Preparar pedido</span>
              </a>
            @endif
            @if ($venta->estado==1)
            <a href="#" class=" btn btn-success btn-icon-split float-right" style="margin-left: 10px;" 
            onclick="if (pendientes_asignacion==1) alert('Debe seleccionar los lotes a enviar'); else window.location.href='{{ url('/venta_cambiar_estado',$venta->id) }}?estado=2';">
              <span class="icon text-white-50">
                  <i class="fas fa-thumbs-up" ></i>
              </span>
              <span class="text">Enviar pedido</span>
            </a>
            @endif
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
              <th scope="col" width="5%">Cant. Pedida</th>
              @if ($venta->estado!=0)
              <th scope="col" width="5%">Cant. a Facturar</th>
              @endif
              <th scope="col">Precio Unitario</th>
              <th scope="col">Total</th>
              @if ($venta->estado!=0)
              <th scope="col" width="10%">Lotes asignados</th>
              @endif
              @if ($venta->estado==1)
              <th scope="col" width="10%">Eliminar Asignacion</th>
              @endif
               @if ($venta->estado==0)
              <th scope="col" align="center">Acciones</th>
              @endif
             
            </tr>
          </thead>
          <tbody>
            <?php $totalPedido=0; ?>
            @foreach ($item_pedidos as $i)
            <tr>
              <td>{{ $i->codigo }}</td>
              <td width="20%">  {{ $i->nombre }}</td>
               <td>{{ $i->unidad_medida}}</td>
              <td align="right"> {{ $i->cantidad }}</td>
              @if ($venta->estado!=0)
              <td align="right">  
                 <?php $asignado=0;?>
              @if (count($asignaciones[$i->id])>0)
                @foreach ($asignaciones[$i->id] as $a)
                         <?php $asignado+=$a->cantidad; ?>
                  @endforeach
                  <span class="<?php if (-$asignado<$i->cantidad) echo "text-danger"; ?>"><?php echo -$asignado; ?> </span>
              @endif
              </td>
              @endif
              <td align="right">
                <form method=POST action="{{url('/modificar_precio_item',$venta->id)}}" id="nuevo_precio_"{{$i->id_item}}>
                  @csrf
                    <input type=hidden name=item value={{$i->id_item}}>
                     $ <input type=text  style="width:80px; text-align: right; <?php if($i->precio==0) echo 'background-color: #FFEDB5;'; else echo 'background-color: #ffffff;' ?>" name=nuevo_precio value={{ number_format($i->precio,2,",",".")}}>
                       <a href="#" class="float-right text-secondary" onclick="document.getElementById('nuevo_precio_{{$i->id_item}}').submit">&nbsp;
                        <span class="icon">
                          <i class="fas fa-recycle"></i> 
                        </span>
                      </a> 
                </form>
                   </td>
              <td align="right">
                   @if ($venta->estado==0)
                     $ {{ number_format($i->cantidad * $i->precio,2,",",".") }}
                     <?php $totalPedido+=$i->cantidad*$i->precio ?>
                   @else
                       $ {{ number_format(-$asignado * $i->precio,2,",",".") }}
                          <?php $totalPedido+=-$asignado*$i->precio ?> 
                   @endif 
                 </td>
              @if ($venta->estado!=0)
              <td align="center">
                @if (count($asignaciones[$i->id])>0)
                    <a href="#" class="text-secondary" title="Ver Lotes Asignados"><i class="fas fa-info-circle fa-2x text--300" data-toggle="modal" data-target="#info_asignacion_{{$i->id}}"></i></a>
                     @if ($venta->estado==1)
                      <td align=center> 
                        <a href="#" class="text-secondary" title="Eliminar Lotes Asignados" onclick="if (confirm('Desea quitar la asignacion de estos productos. Se eliminarán los movimientos'))  window.location.href='{{ url('/desasignar_lotes_venta',$venta->id) }}/{{$i->id}}'">
                          <i class="fas fa-minus-circle fa-2x text--300" ></i>
                        </a>
                      </td>
                    @endif
                @else
                    @if (count($lotes_disponibles[$i->id])>0)
                      <script type="text/javascript"> pendientes_asignacion=1;</script>
                <a href="#" class="text-secondary"><i class="fas fa-edit fa-2x "data-toggle="modal" data-target="#seleccion_asignacion_{{$i->id}}"></i></a>
                    @else
                     <i class="text-danger"> Sin Stock  </i>
                    @endif
                @endif
              </td>
              @endif
              @if ($venta->estado==0)
              <td class="w-10" align="center"> 
                         <a href="{{url('/desasignar_lotes_venta',$venta->id) }}/{{$i->id}}?borrar" class="float-left text-secondary" title="Eliminar Producto">
                        <span class="icon">
                          <i class="fas fa-trash fa-2x"></i> 
                        </span>
                      </a> 
                       <a href="#" class="text-secondary" title="Ver Stock"><i class="fas fa-search fa-2x text--300" data-toggle="modal" data-target="#ver_stock_{{$i->id}}"></i></a>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            @if ($item_pedidos !=null)
                @if ($venta->estado==0)
                    <tr><td colspan=5 align=right>Total Pedido: </td><td align="right"><B><?php echo "$" .number_format($totalPedido,2,",",".") ?> </B></td></tr>
                @else
                     <tr><td colspan=6 align=right>Total Pedido: </td><td align="right"><B><?php echo "$ " .number_format($totalPedido,2,",",".") ?> </B></td></tr>
                @endif     
            @endif     
          </tfoot>
         </table>
        </div>
      </div>  <!--div card-body -->

    

<!-- Modales de seleccion -->
@foreach ($item_pedidos as $i)
<div class="modal fade" id="seleccion_asignacion_{{$i->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

<!-- Modales info de seleccion -->
@foreach ($item_pedidos as $i)
<div class="modal fade" id="info_asignacion_{{$i->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title text-info font-weight-bold text-uppercase mb-3" id="exampleModalLongTitle">Lotes asignados {{$i->nombre}}</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
         <div class="table-responsive"> 
           <?php $subtotal=$i->cantidad; ?>
                <input type=hidden name=precio value="{{$i->precio}}">
             <table class="table table-bordered small" width="100%" cellspacing="0">
                <tr>
                   <th scope="col">Nro. Lote</th>
                   <th scope="col">Fecha Vencimiento</th>
                   <th scope="col">Depósito</th>
                   <th scope="col" style="text-align:center;">Asignados</th>
                </tr>
               @foreach ($asignaciones[$i->id] as $l)
                <tr>
                  <td>{{$l->lote}}</td>
                  <td>{{ date('d-m-Y', strtotime($l->vencimiento))}}</td> 
                   <td>{{$l->nombre_deposito}}</td>
                   <td width=10%>{{-$l->cantidad}}</td>
                </tr>
               @endforeach
             </table>
          </div>
        
      </div>
  </div>
</div>
@endforeach


<!-- Modales de saldos de stock -->
@foreach ($item_pedidos as $i)
<div class="modal fade" id="ver_stock_{{$i->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title text-info font-weight-bold text-uppercase mb-3" id="exampleModalLongTitle">Stock para {{$i->nombre}}</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
         <div class="table-responsive"> 
         
              
             <table class="table table-bordered small" width="100%" cellspacing="0">
                <tr>
                   <th scope="col">Deposito</th>
                   <th scope="col">Saldo</th>  
                   <th scope="col">U.M.</th>      
                </tr>
               @foreach ($saldo_producto[$i->id] as $s)
                <tr>
                  <td>{{$s->nombre}}</td>
                   <td width=20%>{{$s->cantidad}}</td>
                   <td>{{$s->unidad_medida}}</td>
                </tr>
               @endforeach
             </table>
          </div>
        
      </div>
  </div>
</div>
@endforeach


@if ($venta->estado==0)
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
                <i class="fas fa-shopping-cart"></i>
            </span>
            <span class="text">Agregar</span></a>
        </div>
  
</div>
</form>      <!-- /.container-fluid -->
@endif
</div>



@endsection