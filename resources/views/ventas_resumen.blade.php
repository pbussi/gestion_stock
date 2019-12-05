@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Resumen de Ventas</h1>
          <p class="mb-4 m-0 font-weight-bold text-info"> @if ($valor=="2")
                              <b>{{date('d-m-Y', strtotime($desde))}} </b>hasta <b>{{date('d-m-Y', strtotime($hasta))}}</b> </p>
                            @else
                              <b>HISTORICO </b></p>
                            @endif
       
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-0 font-weight-bold text-info"> </h5>
            </div>
            <?php $ventas_total=0;?>
            <div class="card-body">              
                      <div class="table-responsive">
                      <table class="table small" id="dataTableQ" width="70%" cellspacing="0">
                      <thead>
                      <tr>
                        <th scope="col" width="20%">Fecha</th>
                        <th scope="col" width="40%">Razón Social</th>
                        <th scope="col" width="20%" style="text-align:center;">Comprobante Asociado</th>
                        <th scope="col" width="20%" style="text-align: right">Importe Total</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                     <tbody>
                      @foreach ($ventas as $v)
                      <tr>
                         <td>{{date("d/m/Y",strtotime($v->fecha))}}</td>
                         <td>{{$v->razon_social}}</td>
                          <td style="text-align:center;"><a href="{{ url('/ventas_gestion',$v->id) }}">{{$v->comprobante_asociado}}</a></td>
                          <td style="text-align: right">$ {{number_format($v->total,2,".",",")}}</td> 
                          <?php $ventas_total=$ventas_total+$v->total; ?>
                     </tr>
                      @endforeach
                     </tbody> 

                     <tr><td colspan="4" style="text-align:right; font-size: 18px"><?php echo "$ ".number_format($ventas_total,2,".",","); ?></b></td></tr>
                </table>
              </div>
                 
              
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection