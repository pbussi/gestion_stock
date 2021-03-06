
@extends('layout')

@section('content')

 <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Depositos</h1>
          <p class="mb-4">Almacenes manejados por el sistema</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Nuevo deposito</h6>
            </div>
            <div class="card-body">
              

 <form action="{{ url('/deposito_nuevo') }}" id=nuevo_deposito method=POST>
      @csrf
      <div class="form-group">
         <label for="nombre">Nombre</label>
        <input class="form-control" type="text" placeholder="" style="width:50%;" name=nombre>
        <br>
        <label for="direccion">Direccion</label>
        <input class="form-control" type="text" placeholder="" style="width:50%;" name=direccion>
        <br>
        <label for="Descripcion">Descripcion</label>
        <input class="form-control" type="text" placeholder="" style="width:50%;" name=descripcion>


      </div>
        <a href="#"  onclick="document.getElementById('nuevo_deposito').submit();" class="btn btn-success btn-icon-split">
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

