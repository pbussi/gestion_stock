@extends('layout')
@section('content')
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Stock a fecha</h1>
          <p class="mb-4"> por Deposito </p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><b> {{$deposito->nombre}}</b></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped small" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>U.M.</th>
                        <th>Saldo</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($saldos as $s)
                    <tr>
                      <th scope="row">{{ $s->codigo }}</th>
                      
                      <td><a href="{{ url('/movimiento_producto',$s->id) }}">{{ $s->nombre }}</a></td>
                      <td>{{ $s->marca }}</td>
                      <td>{{ $s->unidad_medida }}</td>
                      <td>{{ $s->cantidad }}</td>
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