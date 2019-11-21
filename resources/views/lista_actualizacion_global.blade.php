
@extends('layout')

@section('content')

 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Actualización Global </h1>
          <h6 class="m-0 text-info font-weight-bold text-uppercase mb-4">Lista {{$lista->nombre}}</h6>
          <p class="mb-4"></p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Modificar Lista</h6>
            </div>
            <div class="card-body">
              

 <form action="{{ url('/lista_actualizacion_global') }}" id=lista_actualizacion_global method=POST>
  @csrf
      <div class="form-group">
        <input type=hidden name=id value="{{$lista->id}}"
         <label for="monto">% a Actualizar</label>
        <input class="form-control" type="number" style="width:15%;" name=porcentaje id=porcentaje>
      </div>
        <a href="#"  onclick="document.getElementById('lista_actualizacion_global').submit();" class="btn btn-success btn-icon-split">
         <span class ="icon text-white-50">
                      <i class="fas fa-refresh"></i>
                    </span>
                    <span class="text">Actualizar Lista</span>
        </a>
     
    </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection


