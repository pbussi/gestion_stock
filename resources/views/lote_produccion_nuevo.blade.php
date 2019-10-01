
@extends('layout')

@section('content')

 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Produccion</h1>
          <p class="mb-4">Gestion de la fabricacion de productos</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Nuevo lote de produccion</h6>
            </div>
            <div class="card-body">
              

 <form action="{{ url('/lote_produccion_nuevo') }}" id=nuevo_lote method=POST>
      @csrf
      <div class="form-group">
         <label for="nombre">Nombre</label>
        <input class="form-control" type="date" name=fecha_lote value="{{ date('Y-m-d') }}">
      </div>
        <a href="#"  onclick="document.getElementById('nuevo_lote').submit();" class="btn btn-success btn-icon-split">
         <span class ="icon text-white-50">
                      <i class="fas fa-check-double"></i>
                    </span>
                    <span class="text">Crear</span>
        </a>
     
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection

