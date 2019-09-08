
@extends('layout')

@section('content')
 
 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Depositos</h1>
          <p class="mb-4">Almacenes manejados por el sistema</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Listado de Depositos
              <a href="{{ url('/deposito_nuevo') }}"" class=" btn btn-success btn-icon-split float-right">
                    <span class="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear nuevo Deposito</span>
                  </a>
           </h6>
            


            </div>
            <div class="card-body">
             <div class="table-responsive">
             <table class="table table-bordered small" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                 <th scope="col">Descripcion</th>
                <th scope="col">Direccion</th>
                <th scope="col">Accion</th>
              </tr>
            </thead>
           <tbody>
            @foreach ($depositos as $d)
              <tr>
              <th scope="row">{{ $d->id }}</th>
              <td><a href=""> {{ $d->nombre }}</a></td>
               <td></td>
              <td>{{ $d->direccion }}</td>
              <td class="w-10"> 
                        <a href="#" class="float-left">
                        <span class="icon">
                          <i class="fas fa-edit"></i>
                        </span>
                      </a>
                      &nbsp;  &nbsp;
                      <a href="#" class="">
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
        <!-- /.container-fluid -->



@endsection

{{--

<div class="row">
    <div class="col-sm">
      <a class="btn btn-primary" href="{{ url('/deposito_nuevo') }}" role="button">Nuevo deposito</a>
    </div>
</div>

<div class="row">
    <div class="col-sm">

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Direccion</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($depositos as $d)
    <tr>
      <th scope="row">{{ $d->id }}</th>
      <td><a href=""> {{ $d->nombre }}</a></td>
      <td>{{ $d->direccion }}</td>
      <td> <a class="btn btn-primary" href="#" role="button">Editar</a></td>
    </tr>
    @endforeach
  </tbody>
</table>

    </div>
</div> --}}