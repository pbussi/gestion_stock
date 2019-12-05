@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Ventas no cumplidas por falta de Stock</h1>
          <p class="mb-4 m-0 font-weight-bold text-info"> @if ($valor=="2")
                              <b>{{date('d-m-Y', strtotime($desde))}} </b>hasta <b>{{date('d-m-Y', strtotime($hasta))}}</b> </p>
                            @else
                              <b>HISTORICO </b></p>
                            @endif
       
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-0 font-weight-bold text-info"> </h5>
            </div>
            <?php $r=0;$difSubtot=0;?>
            <div class="card-body">
            
                    @foreach ($resultado as $producto=>$enviados)
                      <p class="text-info"><b>{{$producto}}</b></p>
                      <div class="table-responsive">
                      <table class="table small" id="dataTableQ" width="70%" cellspacing="0">
                      <thead>
                      <tr>
                        <th scope="col" width="20%">Fecha</th>
                        <th scope="col" width="30%">Comprobante</th>
                        <th scope="col" width="40%">Razón Social</th>
                        <th scope="col" width="40%" style="text-align: center">Pedido</th>  
                        <th scope="col" width="30%" style="text-align: center">Remitido </th>   
                        <th scope="col" width="30%" style="text-align: center">Diferencia </th> 
                        <th scope="col" width="30%" style="text-align: right">U.M.</th>  
                      </tr>
                    </thead>
                     <tbody>
                      @foreach ($enviados as $r)
                      <tr>
                         <td>{{date("d/m/Y",strtotime($r['fecha_venta']))}}</td>
                         <td>{{$r['remito']}}</td>
                          <td>{{$r['cliente']}}</td>
                          <td style="text-align: right">{{$r['cant_pedida']}}</td>
                          <td style="text-align: right">{{$r['cant_enviada']}}</td>
                          <td style="text-align: right">{{number_format($r['cant_pedida']-$r['cant_enviada'],2,".",",")}}</td>
                          <td>{{$r['unidad_medida']}}</td>  
                          <?php $difSubtot=$difSubtot+ number_format($r['cant_pedida']-$r['cant_enviada'],2,".",","); ?>                                    
                      </tr>
                       @endforeach
                     </tbody> 
                     <tr><td colspan="7" style="text-align:right;">Ventas Perdidas de {{$producto}}  : <b><?php echo number_format($difSubtot,2,".",","); ?></b></td></tr>
                </table>
              </div>
                    @endforeach
                 
              
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection