@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Detalle de Ventas por Lote </h1>
          <p class="mb-2 m-0 font-weight-bold text-info text-uppercase"> {{$producto->nombre}} - Lote: <a href="{{ url('/lotes_produccion_gestion',$lote) }}"> 
                        <?php echo "PROD".str_pad($lote,6,"0", STR_PAD_LEFT); ?></a> </p>
         
                             
       <?php $cantidad_lote_total=0; ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-0 font-weight-bold text-info"> </h5>
            </div>
                       <div class="card-body">              
                      <div class="table-responsive">
                      <table class="table small" id="dataTableQ" width="70%" cellspacing="0">
                      <thead>
                      <tr>
                        <th scope="col" width="20%">Fecha</th>
                        <th scope="col" width="40%">Razón Social</th>
                        <th scope="col" width="20%" style="text-align:center;">Comprobante Asociado</th>
                        <th scope="col" width="20%" style="text-align: right">Cantidad</th>
                        <th scope="col" width="20%" style="text-align: right">U.M.</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                     <tbody>
                      @foreach ($ventasxlote as $v)
                      <tr>
                         <td>{{date("d/m/Y",strtotime($v->fecha))}}</td>
                         <td>{{$v->razon_social}}</td>
                          <td style="text-align:center;">
                            <a href="{{ url('/venta_gestion',$v->id) }}">{{$v->comprobante_asociado}}</a></td>
                          <td style="text-align: right"> {{$v->cantidad}} </td>
                          <td style="text-align: right"> {{$producto->unidad_medida}} </td>
                            <?php $cantidad_lote_total=$cantidad_lote_total+$v->cantidad; ?>
                          <td></td>
                     </tr> 
                      @endforeach
                     </tbody> 

                     <tr><td colspan="4" style="text-align:right; font-size: 18px">
                      <?php echo "Total Vendido: ".$cantidad_lote_total; ?></b></td></tr>
                </table>
              </div>
                 
              
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection