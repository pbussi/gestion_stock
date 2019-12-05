@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Listado de Ventas por Cliente</h1>
          <p class="mb-4">Remitos despachados desde <b>{{date('d-m-Y', strtotime($desde))}} </b>hasta <b>{{date('d-m-Y', strtotime($hasta))}}</b> </p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-0 font-weight-bold text-info">{{$cliente->razon_social}}</h5>
            </div>
            <?php $totalVentas=0; ?>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table small" id="dataTableQ" width="70%" cellspacing="0">
                  <thead>
                    <tr>
                        <th scope="col" width="20%">Fecha</th>
                         <th scope="col" width="20%">Comprobante Asociado</th>
                        <th scope="col" width="30%" style="text-align: right">$ Total </th>         
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($ventascliente as $venta)
                    <tr>
                     
                      <td class="date">{{date('d-m-Y', strtotime($venta->fecha)) }}</td>
                       <td><a href="{{ url('/venta_gestion',$venta->id) }}">
                        <?php echo "REM".str_pad($venta->id,6,"0", STR_PAD_LEFT); ?></a></td>
                      <td style="text-align: right"> $ 
                        <?php $total=0; ?>
                        @foreach($datos_ventas[$venta->id] as $d)
                            <?php $total=$total + $d->subtotal; ?>
                        @endforeach
                        <?php echo number_format($total,2,",","."); $totalVentas=$totalVentas+$total; ?>
                     </td>                                       
                    </tr>
                    @endforeach
                 
                  </tbody>
                  <tfoot>
                    <tr><td colspan="3" style="text-align: right; font-size: 18px;" ><B> <?php echo "   $ ".number_format($totalVentas,2,",","."); ?></B></td>
                  
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection