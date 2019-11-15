@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Productos Sin Stock</h1>
          <p class="mb-4">  </p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 text-info font-weight-bold text-uppercase mb-4"><b> {{$titulo}}</b>

             <a href="{{ url('productos_sin_stock_pdf',$grupo) }}"  class=" btn btn-warning btn-icon-split float-right" style="margin-left: 10px;">
                    <span class="icon text-white-50">
                      <i class="fas fa-print"></i>
                    </span>
                    <span class="text">Descargar PDF</span>
                  </a>
              
              </h6>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table-bordered table-striped small" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Tipo</th>
                        <th>U.M.</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($saldos as $s)
                    <tr>
                      <th scope="row">{{ $s->codigo }}</th>
                      
                      <td><a href="{{ url('/movimiento_producto',$s->id_producto) }}">{{ $s->nombre }}</a></td>
                      <td>{{ $s->marca }}</td>
                      <td>{{ $s->tipo_producto }}</td>
                      <td>{{ $s->unidad_medida }}</td>
                      
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