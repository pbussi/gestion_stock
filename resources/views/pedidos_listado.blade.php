@extends('layout')

@section('content')
  <script src={{ asset('/vendor/jquery/jquery.min.js') }}></script>
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Listado de Pedidos</h1>
          <p class="mb-4">Gestion de ventas</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pedidos en Sistema</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped small" id="dataTableQ" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">Numero</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Estado</th>         
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
                      <td class="">@if ( $p->estado==0 ) Abierto @else En Preparacion @endif </td>   
                     
                      <td class="w-10"> 
                      <a href="{{ url('/pedidos_listado') }}?borrar={{$p->id}}" class="float-right">
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
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection