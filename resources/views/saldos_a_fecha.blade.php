
@extends('layout')

@section('content')
 
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Stock Actual de Productos</h1>
           <h5 class="font-weight-bold text-primary">Fecha: {{date('d-m-Y')}}</h2></h2>
          <p class="mb-4">En todos los depósitos administrados por el sistema</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            
            <div class="card-body">
             <div class="table-responsive">
             <table class="table  small" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                 <th scope="col">Marca</th>
                <th scope="col">U.M.</th>
                <th scope="col">Saldo</th>
              </tr>
            </thead>
           <tbody>
            @foreach ($stock as $s)
              <tr>

              <th scope="row">{{ $s->id_producto }}</th>
              <td><a href=""> <b>{{ $s->nombre }}</b></a></td>
               <td>{{ $s->marca}}</td>
              <td>{{ $s->unidad_medida }}</td>
              <td> {{ $s->cantidad }}</td>               
                     
            </tr>
            @endforeach
          
          </tbody>
        </table>
      </div>
    </div>
</div>
        <!-- /.container-fluid -->



@endsection

