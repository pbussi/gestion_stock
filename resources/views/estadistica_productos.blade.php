@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Ranking de Venta por Productos</h1>
          <p class="mb-4 m-0 font-weight-bold text-info"> @if ($listado=="2")
                              <b>{{date('d-m-Y', strtotime($desde))}} </b>hasta <b>{{date('d-m-Y', strtotime($hasta))}}</b> </p>
                            @else
                              <b>HISTORICO </b></p>
                            @endif
       
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h5 class="m-0 font-weight-bold text-info"> </h5>
            </div>
            <?php $r=0;?>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table small" id="dataTableQ" width="70%" cellspacing="0">
                  <thead>
                    <tr>
                        <th scope="col" width="20%">Ranking</th>
                         <th scope="col" width="20%">Código</th>
                          <th scope="col" width="50%">Nombre Producto</th>
                          <th scope="col" width="50%">U.M.</th>
                         <th scope="col" width="30%" style="text-align: right">Cantidad Vendida </th>         
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($ranking as $rank)
                    <tr>
                      <td><b><?php $r=$r+1; echo $r ?></b></td>
                      <td>{{$rank->productos_id}}</td>
                       <td><a href="{{ url('/movimiento_producto',$rank->productos_id) }}">
                        {{$rank->nombre}}</a></td>
                        <td>{{$rank->unidad_medida}}</td>
                      <td style="text-align: right">  
                        {{$rank->total_producto}}
                     </td>                                       
                    </tr>
                    @endforeach
                 
                  </tbody>
                 
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection