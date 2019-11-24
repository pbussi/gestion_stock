@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Listado de Pedidos Remitidos</h1>
          <p class="mb-4">Gestion de ventas</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pedidos Despachados</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped small" id="dataTableQ" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">Numero</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>$ Total </th>         
                        <th class="w-10">Accion</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($pedidos as $p)
                    <tr>
                      <td><a href="{{ url('/venta_gestion',$p->id) }}">
                        <?php echo "REM".str_pad($p->id,6,"0", STR_PAD_LEFT); ?>

                      </a></td>
                      <td class="date">{{date('d-m-Y', strtotime($p->fecha)) }}</td>
                      <td class="text-uppercase">{{ $p->razon_social }}</td>    
                      <td align=left>$ {{$totales[$p->id]}} </td>
                      <td class="w-10"> 
                      <a href="{{ url('/venta_gestion',$p->id) }}" class="float-center">
                        <span class="icon text-secondary">
                          <i class="fas fa-info-circle fa-2x"></i>
                        </span>
                      </a>
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